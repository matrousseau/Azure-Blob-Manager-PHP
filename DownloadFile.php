<?php
require_once 'vendor/autoload.php';
require_once "./random_string.php";
use WindowsAzure\Common\ServicesBuilder;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;

$connectionString = "DefaultEndpointsProtocol=https;AccountName=".getenv('ACCOUNT_NAME').";AccountKey=".getenv('ACCOUNT_KEY');

// NOM DU FICHIER A TELECHARGER
$namefile = "testoff.json";

// NOM DU STOCKAGE
// * pour upload : "cs-blob-input"
// * pour download : "cs-blob-output"

$containerName = "cs-blob-output";

// Create blob client.
$blobRestProxy = BlobRestProxy::createBlobService($connectionString);

function export_stream_to_json($test, $namefile) {
  $dest1 = fopen($namefile, 'w');
  stream_copy_to_stream($test, $dest1);
}

if (!isset($_GET["Cleanup"])) {

  try {
    echo $containerName;
    $listBlobsOptions = new ListBlobsOptions();
    do{
        $result = $blobClient->listBlobs($containerName, $listBlobsOptions);
        foreach ($result->getBlobs() as $blob)
        {
            echo $blob->getName().PHP_EOL;
        }

        $listBlobsOptions->setContinuationToken($result->getContinuationToken());
    } while($result->getContinuationToken());

  	// Get blob.
  	$blob = $blobRestProxy->getBlob("cs-blob-input", $namefile);
  	$test = $blob->getContentStream();
    export_stream_to_json($test, $namefile);
}
catch(ServiceException $e){
	echo "error";
  }
}
?>
