<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    $app->get('/[{name}]', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");

        // Render index view
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    });

    // Enable CORS
    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });
    
    $app->add(function ($req, $res, $next) {
        $response = $next($req, $res);
        return $response
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    });

    // Catch-all route to serve a 404 Not Found page if none of the routes match
    // NOTE: make sure this route is defined last
    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function($req, $res) {
        $handler = $this->notFoundHandler; // handle using the default Slim page not found handler
        return $handler($req, $res);
    });

    /**
     * Sends an email to the specified recipients.
     *
     * @param string|array $from The sender of the email.
     * @param array $recipients The list of recipients.
     * @param array $CCs The list of recipients to be cc'd.
     * @param array $BCCs The list of recipients to be bcc'd.
     * @param string $subject The subject of the email.
     * @param string $message The body of the email.
     * @param bool $isHTML Specifies if the email body is HTML.
     * @param array $attachments The list of file attachments.
     * @throws Exception If there is an error sending the email.
     * @return bool|string Returns true if the email is sent successfully,
     *         otherwise returns the error message.
     */
    function mailer($from, $recipients, $CCs, $BCCs, $subject, $message, $isHTML, $attachments)
    {
        // Create a new instance of PHPMailer
        $mail = $container->get("mail");

        // Set the sender of the email
        $mail->setFrom($from);

        // Add recipients
        foreach ($recipients as $recipient) {
            if (is_string($recipient)) {
                $mail->addAddress(strtolower(trim($recipient)));
            } elseif (isset($recipient['name'])) {
                $mail->addAddress(strtolower(trim($recipient['email'])), ucwords(trim($recipient['name'])));
            } else {
                $mail->addAddress(strtolower(trim($recipient['email'])));
            }
        }

        // Add CC recipients
        foreach ($CCs as $cc) {
            if (is_string($cc)) {
                $mail->addCC(strtolower(trim($cc)));
            } elseif (isset($cc['name'])) {
                $mail->addCC(strtolower(trim($cc['email'])), ucwords(trim($cc['name'])));
            } else {
                $mail->addCC(strtolower(trim($cc['email'])));
            }
        }

        // Add BCC recipients
        foreach ($BCCs as $bcc) {
            if (is_string($bcc)) {
                $mail->addBCC(strtolower(trim($bcc)));
            } elseif (isset($bcc['name'])) {
                $mail->addBCC(strtolower(trim($bcc['email'])), ucwords(trim($bcc['name'])));
            } else {
                $mail->addBCC(strtolower(trim($bcc['email'])));
            }
        }

        // Add attachments
        foreach ($attachments as $attachment) {
            $mail->addAttachment($attachment);
        }

        // Set email format to HTML or plain text
        $mail->isHTML($isHTML);

        // Set the subject of the email
        $mail->Subject = $subject;

        // Set the body of the email
        $mail->Body = $message;

        // Set the alternative body of the email (plain text version)
        $mail->AltBody = str_ireplace(array("<br />","<br>","<br/>"), "\r\n", strip_tags($message, '<br>'));

        try {
            // Send the email
            $mail->send();
            return true;
        } catch (Exception $e) {
            // If there is an error sending the email, return the error message
            return $mail->ErrorInfo;
        }
    }

/**
 * Save uploaded files to a custom directory.
 *
 * @param array $files An array of uploaded files.
 * @param string $dir The directory to save the files in. Default is 'uploads'.
 * @return array An array of file paths where the uploaded files were saved.
 */
function saveUploadedFiles(array $files, string $dir = 'uploads'): array {
    // Array to store the paths of saved files
    $saved = [];

    // Get the base directory
    $baseDir = __DIR__ . "/../" . $dir;

    // Loop through each uploaded file
    foreach ($files as $file) {
        // Get the client filename
        $filename = $file->getClientFilename();

        // Set the file path
        $filePath = $baseDir . "/" . $filename;

        // Move the file to the base directory
        $file->move($baseDir, $filename);

        // Add the file path to the saved array
        $saved[] = $filePath;
    }

    // Return the array of saved file paths
    return $saved;
}

/**
 * Save an uploaded image file to a custom directory and create thumbnails for each image.
 * Returns an array containing the paths to the original image and the thumbnail.
 *
 * @param array $file The uploaded file data.
 * @param string $targetDirectory The directory to save the original image.
 * @param string $thumbnailDirectory The directory to save the thumbnail image.
 * @param int $thumbnailWidth The width of the thumbnail image.
 * @param int $thumbnailHeight The height of the thumbnail image.
 * @return array|bool An array containing the paths to the original image and the thumbnail,
 *                    or false if there was an error.
 */
function saveImageWithThumbnails($file, $targetDirectory, $thumbnailDirectory, $thumbnailWidth, $thumbnailHeight)
{
    // Check if the file is an image
    if (!getimagesize($file["tmp_name"])) {
        return false; // Not an image, handle the error
    }

    // Generate a unique filename for the image
    $fileName = uniqid() . '_' . $file["name"];

    // Move the original image to the target directory
    $targetPath = $targetDirectory . '/' . $fileName;
    if (!move_uploaded_file($file["tmp_name"], $targetPath)) {
        return false; // Failed to move the file, handle the error
    }

    // Create a thumbnail image
    $thumbnailPath = $thumbnailDirectory . '/' . $fileName;
    $thumbnail = imagecreatetruecolor($thumbnailWidth, $thumbnailHeight);
    $sourceImage = imagecreatefromjpeg($targetPath); // Change this based on the image type
    imagecopyresized($thumbnail, $sourceImage, 0, 0, 0, 0, $thumbnailWidth, $thumbnailHeight, imagesx($sourceImage), imagesy($sourceImage));
    imagedestroy($sourceImage);
    if (!imagejpeg($thumbnail, $thumbnailPath)) { // Change this based on the image type
        return false; // Failed to create the thumbnail, handle the error
    }

    return [
        'original' => $targetPath,
        'thumbnail' => $thumbnailPath
    ];
}
    

};

