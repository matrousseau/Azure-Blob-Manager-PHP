---
services: storage
platforms: php
author: roygara
---

# Transfer objects to and from Azure Blob storage using PHP

This repository contains a simple sample project to help you getting started with Azure storage using .NET as the development language.

## Prerequisites

To complete this tutorial:

To complete this quickstart:
* Install [PHP](http://php.net/downloads.php)
* Install [The Azure SDK for PHP](../../php-download-sdk.md)


## Put the connection string in an environment variable

This solution requires a connection string be stored in an environment variable securely on the machine running the sample. Follow one of the examples below depending on your Operating System to create the environment variable. If using windows close out of your open IDE or shell and restart it to be able to read the environment variable.

### Linux

```bash
export ACCOUNT_NAME=<youraccountname>
export ACCOUNT_KEY=<youraccountkey>
```
### Windows

```cmd
setx ACCOUNT_NAME=<youraccountname>
setx ACCOUNT_KEY=<youraccountkey>
```

## Installation

Open a command shell and type php composer.phar install

The [Azure storage documentation](https://docs.microsoft.com/azure/storage/) includes a rich set of tutorials and conceptual articles, which serve as a good complement to the samples.

This project has adopted the [Microsoft Open Source Code of Conduct](https://opensource.microsoft.com/codeofconduct/).
For more information see the [Code of Conduct FAQ](https://opensource.microsoft.com/codeofconduct/faq/) or
contact [opencode@microsoft.com](mailto:opencode@microsoft.com) with any additional questions or comments.
