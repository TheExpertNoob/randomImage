<?php
// Define the directory where your images are stored
$imageDirectory = 'randomImages/';

// Get the requested image file from the query parameter
$imageFile = isset($_GET['image']) ? $_GET['image'] : null;

// Check if the requested image file exists in the directory
if ($imageFile !== null && file_exists($imageDirectory . $imageFile)) {
    // Determine the file extension of the selected image
    $fileExtension = pathinfo($imageFile, PATHINFO_EXTENSION);

    // Set the appropriate Content-Type header based on the file extension
    if (in_array($fileExtension, ['jpg', 'jpeg'])) {
        header('Content-Type: image/jpeg');
    } elseif ($fileExtension === 'png') {
        header('Content-Type: image/png');
    }
	
	// Set Cache-Control headers to prevent caching
	header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
	header('Cache-Control: post-check=0, pre-check=0', false);
	header('Pragma: no-cache');

    // Output the selected image directly to the browser
    readfile($imageDirectory . $imageFile);
} else {
    // If no specific image is requested or the requested image does not exist, serve a random image
    $imageFiles = glob($imageDirectory . '*.{jpg,jpeg,png}', GLOB_BRACE);

    if (count($imageFiles) > 0) {
        // Select a random image from the list
        $randomImage = $imageFiles[array_rand($imageFiles)];

        // Determine the file extension of the random image
        $fileExtension = pathinfo($randomImage, PATHINFO_EXTENSION);

        // Set the appropriate Content-Type header based on the file extension
        if (in_array($fileExtension, ['jpg', 'jpeg'])) {
            header('Content-Type: image/jpeg');
        } elseif ($fileExtension === 'png') {
            header('Content-Type: image/png');
        }

		// Set Cache-Control headers to prevent caching
		header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
		header('Cache-Control: post-check=0, pre-check=0', false);
		header('Pragma: no-cache');
		
        // Output the random image directly to the browser
        readfile($randomImage);
    } else {
        // If no image files are found in the directory, display an error message
        echo 'Image not found.';
    }
}
?>
