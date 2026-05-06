<?php

namespace App\Services;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;
use Google\Service\Drive\Permission;

class GoogleDriveService
{
    protected Client $client;
    protected Drive $driveService;
    protected string $rootFolderId;

    public function __construct()
    {
        $this->client = new Client();
        
        $credsPath = config('services.google.credentials_path');
        
        if (file_exists($credsPath)) {
            $this->client->setAuthConfig($credsPath);
        }
        
        $this->client->addScope(Drive::DRIVE_FILE);
        $this->driveService = new Drive($this->client);
        $this->rootFolderId = config('services.google.root_folder_id', 'root');
    }

    public function uploadSurat(string $pdfContent, string $nik, string $nomorSurat): array
    {
        try {
            // 1. Get or create NIK folder inside "Arsip Surat"
            $arsipFolderId = $this->getOrCreateFolder($this->rootFolderId, 'Arsip Surat');
            $userFolderId = $this->getOrCreateFolder($arsipFolderId, $nik);

            // 2. Prepare file metadata
            $fileName = str_replace(['/', '\\'], '-', $nomorSurat) . '.pdf';
            $fileMetadata = new DriveFile([
                'name' => $fileName,
                'parents' => [$userFolderId],
            ]);

            // 3. Create file
            $file = $this->driveService->files->create($fileMetadata, [
                'data' => $pdfContent,
                'mimeType' => 'application/pdf',
                'uploadType' => 'multipart',
                'fields' => 'id, webViewLink'
            ]);

            // 4. Set permission to anyone with link (reader)
            $permission = new Permission([
                'type' => 'anyone',
                'role' => 'reader',
            ]);
            $this->driveService->permissions->create($file->id, $permission);

            return [
                'id' => $file->id,
                'url' => $file->webViewLink,
            ];
        } catch (\Exception $e) {
            \Log::error('Google Drive Upload Error: ' . $e->getMessage());
            throw $e;
        }
    }

    private function getOrCreateFolder(string $parentId, string $folderName): string
    {
        $query = "name = '$folderName' and mimeType = 'application/vnd.google-apps.folder' and '$parentId' in parents and trashed = false";
        $results = $this->driveService->files->listFiles(['q' => $query]);

        if (count($results->getFiles()) > 0) {
            return $results->getFiles()[0]->getId();
        }

        // Create new folder
        $folderMetadata = new DriveFile([
            'name' => $folderName,
            'mimeType' => 'application/vnd.google-apps.folder',
            'parents' => [$parentId],
        ]);

        $folder = $this->driveService->files->create($folderMetadata, ['fields' => 'id']);
        return $folder->id;
    }
}
