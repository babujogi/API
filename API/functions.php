<?php
// Function to highlight keywords
function highlight_keywords($text) {
    // Define patterns and colors for highlighting
    $patterns = [
        '/(notification)/i' => '<span class="notification mode">$1</span>',
        '/(important)/i' => '<span class="important mode">$1</span>',  // Keyword "important"
        '/(error)/i' => '<span class="error mode">$1</span>'  // Keyword "error"
    ];

    // Replace the keywords with highlighted versions
    foreach ($patterns as $pattern => $replacement) {
        $text = preg_replace($pattern, $replacement, $text);
    }

    return $text;
}

function save_message($text, $headers) {
    $date = date('Y-m-d');
    $file = __DIR__ . "/log/{$date}-message.log";

    // Sanitize text
    $text = htmlspecialchars(strip_tags($text), ENT_QUOTES, 'UTF-8');

    if (!is_dir(__DIR__ . "/log")) {
        mkdir(__DIR__ . "/log", 0755, true);
    }

    $file_handle = fopen($file, 'a');
    if ($file_handle === false) {
        return "Error opening the file.";
    }

    $mode = isset($headers['Mode']) ? htmlspecialchars(strip_tags($headers['Mode'])) : 'no mode';
    $ip = isset($headers['IP']) ? htmlspecialchars(strip_tags($headers['IP'] . $headers['port'])) : 'not set';

    $time = date('Y-m-d H:i:s');
    $entry = '<div style="border:2px solid white; border-radius:5px; padding:15px; background-color:blue; margin-bottom:15px; display:flex; flex-direction:row; justify-content: space-between;"><div>' 
            . $time . " [{$mode}][{$ip}]: " . $text . "</div></div>\n";

    fwrite($file_handle, $entry);
    fclose($file_handle);

    if (!empty($_FILES['file']['name'])) {
        $upload_dir = __DIR__ . "/uploads/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $filename = basename($_FILES["file"]["name"]);
        $filename = preg_replace("/[^a-zA-Z0-9\.\-_]/", "_", $filename); // sanitize filename
        $target_path = $upload_dir . $filename;

        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];

        if (in_array(mime_content_type($_FILES["file"]["tmp_name"]), $allowed_types)) {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_path)) {
                echo "Image uploaded to: $target_path";
            } else {
                echo "Failed to upload image.";
                return "ERROR";
            }
        } else {
            echo "Invalid file type.";
            return "ERROR";
        }
    }
    return "SUCCESS";
}
?>
