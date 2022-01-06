<?php
declare(strict_types=1);

namespace Arobases\SyliusCustomerSupportPlugin\Files\Uploader;

use Arobases\SyliusCustomerSupportPlugin\Files\Provider\FileNameProvider;
use Symfony\Component\Filesystem\Filesystem;

final class CustomerSupportAnswerUploader extends FileUploader {

    public function __construct(Filesystem $fileSystem, FileNameProvider $fileNameProvider, string $customerSupportAnswerBaseUploadPath, string $customerSupportAnswerComplementUploadPath)
    {
        parent::__construct($fileSystem, $fileNameProvider, $customerSupportAnswerBaseUploadPath, $customerSupportAnswerComplementUploadPath);
    }

}
