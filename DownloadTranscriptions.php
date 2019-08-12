<?php

require_once 'vendor/autoload.php';

use WindowsAzure\Common\ServicesBuilder;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;

$connectionString = "DefaultEndpointsProtocol=https;AccountName=".getenv('ACCOUNT_NAME').";AccountKey=".getenv('ACCOUNT_KEY');

// NOM DU FICHIER A TELECHARGER
$namefile = "20190420_065632-54910-33627057250-IN_brut.json";

// Create blob client.
$blobRestProxy = BlobRestProxy::createBlobService($connectionString);

function export_stream_to_json($test, $namefile) {
  $dest1 = fopen($namefile, 'w');
  stream_copy_to_stream($test, $dest1);
}

if (!isset($_GET["Cleanup"])) {

// NOM DU STOCKAGE
// * pour upload : "cs-blob-input"
// * pour download : "cs-blob-output"
      $containerName = "cs-blob-output";

    try {

        $listBlobsOptions = new ListBlobsOptions();
        echo "These are the blobs present in the container: ".PHP_EOL;

        do{
            $result = $blobRestProxy->listBlobs($containerName, $listBlobsOptions);
            foreach ($result->getBlobs() as $blob)
            {
                echo $blob->getName().PHP_EOL;
            }

            $listBlobsOptions->setContinuationToken($result->getContinuationToken());
        } while($result->getContinuationToken());

        // Get blob.
      	$blob = $blobRestProxy->getBlob($containerName, $namefile);
      	$blobstream = $blob->getContentStream();
        export_stream_to_json($blobstream, $namefile);



    }
    catch(ServiceException $e){
        $code = $e->getCode();
        $error_message = $e->getMessage();
        echo $code.": ".$error_message."<br />";
    }
    catch(InvalidArgumentTypeException $e){
        // Handle exception based on error codes and messages.
        // Error codes and messages are here:
        // http://msdn.microsoft.com/library/azure/dd179439.aspx
        $code = $e->getCode();
        $error_message = $e->getMessage();
        echo $code.": ".$error_message."<br />";
    }
}
else
{

    try{
        // Delete container.
        echo "Deleting Container".PHP_EOL;
        echo $_GET["containerName"].PHP_EOL;
        echo "<br />";
        $blobRestProxy->deleteContainer($_GET["containerName"]);
    }
    catch(ServiceException $e){
        $code = $e->getCode();
        $error_message = $e->getMessage();
        echo $code.": ".$error_message."<br />";
    }
}
?>
