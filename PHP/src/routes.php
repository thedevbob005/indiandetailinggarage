<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;

return function (App $app) {
    $container = $app->getContainer();

    $app->get('/', function (Request $request, Response $response, array $args) use ($container) {
        // Access logger
        $container->get('logger')->info("Home page accessed from {$_SERVER['REMOTE_ADDR']} using {$_SERVER['HTTP_USER_AGENT']}");

        // Render index view
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    });

    $app->get('/about-us', function (Request $request, Response $response, array $args) use ($container) {
        // Access logger
        $container->get('logger')->info("About us page accessed from {$_SERVER['REMOTE_ADDR']} using {$_SERVER['HTTP_USER_AGENT']}");

        // Render index view
        return $container->get('renderer')->render($response, 'about-us.phtml', $args);
    });

    $app->get('/services', function (Request $request, Response $response, array $args) use ($container) {
        // Access logger
        $container->get('logger')->info("Services page accessed from {$_SERVER['REMOTE_ADDR']} using {$_SERVER['HTTP_USER_AGENT']}");

        // Render index view
        return $container->get('renderer')->render($response, 'service.phtml', $args);
    });

    $app->get('/accessories/detailing', function (Request $request, Response $response, array $args) use ($container) {
        // Access logger
        $container->get('logger')->info("Detailing Accessories page accessed from {$_SERVER['REMOTE_ADDR']} using {$_SERVER['HTTP_USER_AGENT']}");

        if(isset($_GET['page'])) {
            $stmt = $container->get('db')->query("SELECT * FROM products WHERE active = 1 AND category = 'Detailing' LIMIT " . ( $_GET['page'] - 1 ) * 10 . ", 10");
            $args['products'] = $stmt->fetchAll();
            $args['page'] = $_GET['page'];
            $stmt = $container->get('db')->query("SELECT COUNT(product_id) as postCount FROM products WHERE active = 1 AND category = 'Detailing'");
            $args['postCount'] = $stmt->fetch()['postCount'];
        } else {
            $stmt = $container->get('db')->query("SELECT * FROM products WHERE active = 1 AND category = 'Detailing' LIMIT 10");
            $args['products'] = $stmt->fetchAll();
            $args['page'] = 1;
            $stmt = $container->get('db')->query("SELECT COUNT(product_id) as postCount FROM products WHERE active = 1 AND category = 'Detailing'");
            $args['postCount'] = $stmt->fetch()['postCount'];
        }

        // Render index view
        return $container->get('renderer')->render($response, 'work.phtml', $args);
    });

    $app->get('/accessories/modification', function (Request $request, Response $response, array $args) use ($container) {
        // Access logger
        $container->get('logger')->info("Modification Accessories page accessed from {$_SERVER['REMOTE_ADDR']} using {$_SERVER['HTTP_USER_AGENT']}");

        if(isset($_GET['page'])) {
            $stmt = $container->get('db')->query("SELECT * FROM products WHERE active = 1 AND category = 'Modification' LIMIT " . ( $_GET['page'] - 1 ) * 10 . ", 10");
            $args['products'] = $stmt->fetchAll();
            $args['page'] = $_GET['page'];
            $stmt = $container->get('db')->query("SELECT COUNT(product_id) as postCount FROM products WHERE active = 1 AND category = 'Modification'");
            $args['postCount'] = $stmt->fetch()['postCount'];
        } else {
            $stmt = $container->get('db')->query("SELECT * FROM products WHERE active = 1 AND category = 'Modification' LIMIT 10");
            $args['products'] = $stmt->fetchAll();
            $args['page'] = 1;
            $stmt = $container->get('db')->query("SELECT COUNT(product_id) as postCount FROM products WHERE active = 1 AND category = 'Modification'");
            $args['postCount'] = $stmt->fetch()['postCount'];
        }

        // Render index view
        return $container->get('renderer')->render($response, 'work-2.phtml', $args);
    });

    $app->get('/blog', function (Request $request, Response $response, array $args) use ($container) {
        // Access logger
        $container->get('logger')->info("Blog page accessed from {$_SERVER['REMOTE_ADDR']} using {$_SERVER['HTTP_USER_AGENT']}");

        if(isset($_GET['page'])) {
            $stmt = $container->get('db')->query("SELECT * FROM blogs WHERE active = 1 LIMIT " . ( $_GET['page'] - 1 ) * 10 . ", 10");
            $args['blogs'] = $stmt->fetchAll();
            $args['page'] = $_GET['page'];
            $stmt = $container->get('db')->query("SELECT COUNT(blog_id) as postCount FROM blogs WHERE active = 1");
            $args['postCount'] = $stmt->fetch()['postCount'];
        } else {
            $stmt = $container->get('db')->query("SELECT * FROM blogs WHERE active = 1 LIMIT 10");
            $args['blogs'] = $stmt->fetchAll();
            $args['page'] = 1;
            $stmt = $container->get('db')->query("SELECT COUNT(blog_id) as postCount FROM blogs WHERE active = 1");
            $args['postCount'] = $stmt->fetch()['postCount'];
        }

        // Render index view
        return $container->get('renderer')->render($response, 'blog.phtml', $args);
    });

    $app->get('/blog/{slug}', function (Request $request, Response $response, array $args) use ($container) {
        // Access logger
        $container->get('logger')->info("{$args['slug']} blog page accessed from {$_SERVER['REMOTE_ADDR']} using {$_SERVER['HTTP_USER_AGENT']}");

        $stmt = $container->get('db')->query("SELECT * FROM blogs WHERE slug = '{$args['slug']}'");
        $args['blog'] = $stmt->fetch();

        // Render index view
        return $container->get('renderer')->render($response, 'single-post.phtml', $args);
    });

    $app->get('/contact', function (Request $request, Response $response, array $args) use ($container) {
        // Access logger
        $container->get('logger')->info("Contact page accessed from {$_SERVER['REMOTE_ADDR']} using {$_SERVER['HTTP_USER_AGENT']}");

        // Render index view
        return $container->get('renderer')->render($response, 'contact.phtml', $args);
    });

    $app->post('/api/blog/new', function (Request $request, Response $response, array $args) use ($container) {
        // Access logger
        $container->get('logger')->info("API accessed from {$_SERVER['REMOTE_ADDR']} using {$_SERVER['HTTP_USER_AGENT']}");

        // Save uploaded file to uploads directory
        $uploadedFile = $request->getUploadedFiles()['poster'];
        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $filename = moveUploadedFile(__DIR__ . '/../public/uploads', $uploadedFile);

            // save to db using pdo
            try {
                $db = $container->get('db');
                $stmt = $db->prepare("INSERT INTO blogs (title, shortdescription, content, poster, slug, tags) VALUES (:title, :shortdescription, :content, :poster, :slug, :tags)");
                $stmt->execute([
                    'title' => $request->getParsedBody()['title'],
                    'shortdescription' => $request->getParsedBody()['shortdescription'],
                    'content' => $request->getParsedBody()['content'],
                    'poster' => $filename,
                    'slug' => $request->getParsedBody()['slug'],
                    'tags' => $request->getParsedBody()['tags']
                ]);
            } catch (\Throwable $th) {
                return $response->withStatus(200)->withJson(['status' => $th->getMessage()]);
            }
            
            
            // return posetive response
            return $response->withStatus(200)->withJson(['status' => 'success']);
        }

        return $response->withStatus(200)->withJson(['status' => "file upload failed"]);
    });

    $app->get('/api/blog', function (Request $request, Response $response, array $args) use ($container) {
        // Access logger
        $container->get('logger')->info("API accessed from {$_SERVER['REMOTE_ADDR']} using {$_SERVER['HTTP_USER_AGENT']}");

        // get posts from table blogs using pdo
        $stmt = $container->get('db')->query("SELECT * FROM blogs");
        $posts = $stmt->fetchAll();
        return $response->withJson([
            'status' => 'success',
            'data' => $posts
        ]);
    });

    $app->get('/api/blog/toggleactive/{blogid}', function (Request $request, Response $response, array $args) use ($container) {
        // Access logger
        $container->get('logger')->info("API accessed from {$_SERVER['REMOTE_ADDR']} using {$_SERVER['HTTP_USER_AGENT']}");

        $blogid = $args['blogid'];
        // update the post from table blogs by blog_id
        $stmt = $container->get('db')->prepare("UPDATE blogs SET active = NOT active WHERE blog_id = ?");
        $stmt->execute([$blogid]);

        // get posts from table blogs using pdo
        $stmt = $container->get('db')->query("SELECT * FROM blogs");
        $posts = $stmt->fetchAll();
        return $response->withJson([
            'status' => 'success',
            'data' => $posts
        ]);
    });

    $app->post('/api/products/new', function (Request $request, Response $response, array $args) use ($container) {
        // Access logger
        $container->get('logger')->info("API accessed from {$_SERVER['REMOTE_ADDR']} using {$_SERVER['HTTP_USER_AGENT']}");

        // Save uploaded file to uploads directory
        $uploadedFile01 = $request->getUploadedFiles()['image01'];
        $filename01 = moveUploadedFile(__DIR__ . '/../public/uploads', $uploadedFile01);

        $dbkeys = 'image01';
        $dbvalues = "'{$filename01}'";

        if(is_uploaded_file($_FILES['image02']['tmp_name'])) {
            $uploadedFile02 = $request->getUploadedFiles()['image02'];
            $filename02 = moveUploadedFile(__DIR__ . '/../public/uploads', $uploadedFile02);

            $dbkeys .= ', image02';
            $dbvalues .= ", '{$filename02}'";
        }

        if(is_uploaded_file($_FILES['image03']['tmp_name'])) {
            $uploadedFile03 = $request->getUploadedFiles()['image03'];
            $filename03 = moveUploadedFile(__DIR__ . '/../public/uploads', $uploadedFile03);

            $dbkeys .= ', image03';
            $dbvalues .= ", '{$filename03}'";
        }

        if(is_uploaded_file($_FILES['image04']['tmp_name'])) {
            $uploadedFile04 = $request->getUploadedFiles()['image04'];
            $filename04 = moveUploadedFile(__DIR__ . '/../public/uploads', $uploadedFile04);

            $dbkeys .= ', image04';
            $dbvalues .= ", '{$filename04}'";
        }

        if(is_uploaded_file($_FILES['image05']['tmp_name'])) {
            $uploadedFile05 = $request->getUploadedFiles()['image05'];
            $filename05 = moveUploadedFile(__DIR__ . '/../public/uploads', $uploadedFile05);

            $dbkeys .= ', image05';
            $dbvalues .= ", '{$filename05}'";
        }



        // save to db using pdo
        try {
            $db = $container->get('db');
            $sql = "INSERT INTO products(name, slug, code, mrp, price, category, inventory, short, description, imagedesctwo, imagedescthree, imagedescfour, imagedescfive, " .  $dbkeys . ") VALUES('{$request->getParsedBody()['productName']}', '{$request->getParsedBody()['productSlug']}', '{$request->getParsedBody()['productCode']}', '{$request->getParsedBody()['productMRP']}', '{$request->getParsedBody()['productPrice']}', '{$request->getParsedBody()['productCategory']}', '{$request->getParsedBody()['productInventory']}', '{$request->getParsedBody()['productShort']}', '{$request->getParsedBody()['productDescription']}', '{$request->getParsedBody()['productImageDesc02']}', '{$request->getParsedBody()['productImageDesc03']}', '{$request->getParsedBody()['productImageDesc04']}', '{$request->getParsedBody()['productImageDesc05']}', " .  $dbvalues . ")";
            $stmt = $db->query($sql);
            // $stmt->execute();
            // return posetive response
            return $response->withStatus(200)->withJson(['status' => 'success']);
        } catch (\Throwable $th) {
            return $response->withStatus(200)->withJson(['status' => $th->getMessage(), 'sql' => $sql]);
        }
    });

    $app->get('/api/products', function (Request $request, Response $response, array $args) use ($container) {
        // Access logger
        $container->get('logger')->info("API accessed from {$_SERVER['REMOTE_ADDR']} using {$_SERVER['HTTP_USER_AGENT']}");

        // get posts from table blogs using pdo
        $stmt = $container->get('db')->query("SELECT * FROM products");
        $posts = $stmt->fetchAll();
        return $response->withJson([
            'status' => 'success',
            'data' => $posts
        ]);
    });

    $app->get('/api/products/toggleactive/{productid}', function (Request $request, Response $response, array $args) use ($container) {
        // Access logger
        $container->get('logger')->info("API accessed from {$_SERVER['REMOTE_ADDR']} using {$_SERVER['HTTP_USER_AGENT']}");

        $productid = $args['productid'];
        // update the post from table blogs by blog_id
        $stmt = $container->get('db')->prepare("UPDATE products SET active = NOT active WHERE product_id = ?");
        $stmt->execute([$productid]);

        // get posts from table blogs using pdo
        $stmt = $container->get('db')->query("SELECT * FROM blogs");
        $posts = $stmt->fetchAll();
        return $response->withJson([
            'status' => 'success',
            'data' => $posts
        ]);
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
     * Moves the uploaded file to the upload directory and assigns it a unique name
     * to avoid overwriting an existing uploaded file.
     *
     * @param string $directory directory to which the file is moved
     * @param UploadedFile $uploadedFile file uploaded file to move
     * @return string filename of moved file
     */
    function moveUploadedFile($directory, UploadedFile $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
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

