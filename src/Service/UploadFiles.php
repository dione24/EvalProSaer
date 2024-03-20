<?php

namespace App\Service;

use App\Entity\Projet;
use App\Entity\Fichiers;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadFiles
{


    public function __construct(private EntityManagerInterface $entityManager, private string $filesDirectory)
    {
        $this->entityManager = $entityManager;
        $this->filesDirectory = $filesDirectory;
    }

    public function uploadFile($file, Projet $projet): void
    {
        // Verify if a file has been uploaded
        if ($file === null || !$file instanceof UploadedFile) {
            throw new \InvalidArgumentException("No file uploaded.");
        }

        // Verify file size (maximum 5 MB)
        if ($file->getSize() > 5 * 1024 * 1024) { // 5 MB in bytes
            throw new \InvalidArgumentException("File size exceeds the maximum limit of 5 MB.");
        }

        // Verify file extension (allow only PDF, Word, Excel)
        $allowedExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];
        $fileExtension = strtolower($file->guessExtension()); // Get the file extension
        if (!in_array($fileExtension, $allowedExtensions)) {
            throw new \InvalidArgumentException("Only PDF, Word, and Excel files are allowed.");
        }

        // Get the original filename
        $originalFileName = $file->getClientOriginalName();

        // Move the file to the destination directory with the original filename
        $file->move($this->filesDirectory, $originalFileName);

        // Create a new Fichiers entity and persist it
        $fichier = new Fichiers();
        $fichier->setName($originalFileName);
        $fichier->setProjet($projet);
        $fichier->setCreatedAt(new \DateTimeImmutable());
        $fichier->setUpdatedAt(new \DateTimeImmutable());
        $this->entityManager->persist($fichier);
        $this->entityManager->flush();
    }
}
