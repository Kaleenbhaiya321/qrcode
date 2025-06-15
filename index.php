<?php
/**
 * QRcdr - php QR Code generator
 * config.php
 *
 * Main configuration settings
 *
 * PHP version 5.4+
 *
 * @category  PHP
 * @package   QRcdr
 * @author    CampCodes<https://campcodes.com>
 * @copyright 2015-2024 CampCodes
 * @license   item sold on campcodes https://campcodes.com
 * @link      https://campcodes.com
 * @link      
 */
$version = '5.3.7';

if (version_compare(phpversion(), '5.4', '<')) {
    exit("QRcdr requires at least PHP version 5.4");
}


if (!filter_var( ini_get( 'allow_url_fopen' ), FILTER_VALIDATE_BOOLEAN ) )  {
    exit("Please enable <code>allow_url_fopen<code>");
}
if (!function_exists('mime_content_type')) {
    exit("Please enable the <code>fileinfo</code> extension");
}
// Update this path if you have a custom relative path inside config.php
require dirname(__FILE__)."/lib/functions.php";

if (qrcdr()->getConfig('debug_mode')) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(E_ALL ^ E_NOTICE);
}
$relative = qrcdr()->relativePath();
require dirname(__FILE__).'/'.$relative.'include/head.php';
?>
<!doctype html>
<html lang="<?php echo $lang; ?>" dir="<?php echo $rtl['dir']; ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <title><?php echo qrcdr()->getString('title'); ?></title>
        <meta name="description" content="<?php echo qrcdr()->getString('description'); ?>">
        <meta name="keywords" content="<?php echo qrcdr()->getString('tags'); ?>">
        <link rel="shortcut icon" href="<?php echo $relative; ?>images/favicon.ico">
        <link href="<?php echo $relative; ?>bootstrap/css/bootstrap<?php echo $rtl['css']; ?>.min.css" rel="stylesheet">
        <link href="<?php echo $relative; ?>css/font-awesome.min.css" rel="stylesheet">
        <script src="<?php echo $relative; ?>js/jquery-3.7.1.min.js"></script>
		
        <?php
        $custom_page = false;
        $body_class = '';
        if (isset($_GET['p'])) {
            $load_page = dirname(__FILE__).'/'.$relative.'template/'.$_GET['p'].'.html';
            if (file_exists($load_page)) {
                $custom_page = file_get_contents($load_page);
            }
        }
        qrcdr()->loadQRcdrCSS($version);
        if (!$custom_page) {
            $body_class = 'qrcdr';
            qrcdr()->loadPluginsCss();
        }
        qrcdr()->setMainColor(qrcdr()->getConfig('color_primary'));
        ?>
    </head>
    <body class="<?php echo $body_class; ?>">
	
        <?php
        if (file_exists(dirname(__FILE__).'/'.$relative.'template/navbar.php')) {
            include dirname(__FILE__).'/'.$relative.'template/navbar.php';
        }
        if (file_exists(dirname(__FILE__).'/'.$relative.'template/header.php')) {
            include dirname(__FILE__).'/'.$relative.'template/header.php';
        }
        if ($custom_page) {
            echo '<div class="container mt-4">'.$custom_page.'</div>';
        } else {
            // Generator
            include dirname(__FILE__).'/'.$relative.'include/generator.php';
        }
        qrcdr()->loadQRcdrJS($version);

        if (!$custom_page) {
            qrcdr()->loadPlugins();
        }
        if (file_exists(dirname(__FILE__).'/'.$relative.'template/footer.php')) {
            include dirname(__FILE__).'/'.$relative.'template/footer.php';
        }
        ?>
    </body>
	<style>
            body {
                background: linear-gradient(135deg, #1a2980 0%, #26d0ce 100%) !important;
                color: #fff;
                min-height: 100vh;
            }
            .card, .modal-content {
                background-color: rgba(255, 255, 255, 0.9);
                border: none;
                border-radius: 10px;
                box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            }
            .card-header {
                background-color: rgba(255, 255, 255, 0.95);
                border-bottom: 1px solid rgba(0, 0, 0, 0.1);
                border-radius: 10px 10px 0 0 !important;
                color: #1a2980;
                font-weight: 600;
            }
            .nav-tabs .nav-link {
                color: rgba(255, 255, 255, 0.8);
                border: none;
            }
            .nav-tabs .nav-link.active {
                color: #fff;
                background-color: transparent;
                border-bottom: 2px solid #fff;
                font-weight: bold;
            }
            .btn-primary {
                background-color: #1a2980;
                border-color: #1a2980;
            }
            .btn-primary:hover {
                background-color: #14216b;
                border-color: #14216b;
            }
            .form-control, .custom-select {
                border: 1px solid rgba(0, 0, 0, 0.1);
                background-color: rgba(255, 255, 255, 0.9);
            }
            .text-muted {
                color: rgba(255, 255, 255, 0.7) !important;
            }
            a {
                color: #fff;
                text-decoration: underline;
            }
            a:hover {
                color: rgba(255, 255, 255, 0.8);
            }
            .footer {
                color: rgba(255, 255, 255, 0.8);
                background-color: rgba(0, 0, 0, 0.1);
                padding: 20px 0;
                margin-top: 30px;
            }
            .qr-code-container {
                background-color: white;
                padding: 15px;
                border-radius: 8px;
                display: inline-block;
            }
            .navbar {
                background-color: rgba(0, 0, 0, 0.2) !important;
                backdrop-filter: blur(10px);
            }
            .dropdown-menu {
                background-color: rgba(255, 255, 255, 0.95);
            }
            .dropdown-item {
                color: #1a2980;
            }
            .dropdown-item:hover {
                background-color: rgba(26, 41, 128, 0.1);
            }
			
			/* Navigation animations */
.nav-zoom .nav-item {
    transition: transform 0.3s ease;
}

.nav-zoom .nav-item:hover {
    transform: scale(1.05);
}

.nav-link {
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    border-radius: 8px !important;
    padding: 10px 15px;
    margin: 3px 0;
}

.nav-link.active {
    box-shadow: 0 4px 8px rgb(255 255 255 / 34%);
    font-weight: bold;
}

.nav-hover-effect {
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: all 0.6s ease;
}

.nav-link:hover .nav-hover-effect {
    left: 100%;
}

.nav-text {
    transition: all 0.3s ease;
    transform: translateX(0);
}

.nav-link:hover .nav-text {
    transform: translateX(5px);
}

/* Animate.css fadeIn animation */
.animated {
    animation-duration: 0.5s;
    animation-fill-mode: both;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.fadeIn {
    animation-name: fadeIn;
}

/* Responsive adjustments */
@media (max-width: 767px) {
    .nav-zoom .nav-item:hover {
        transform: none;
    }
}

/* Custom styling for text area */
        textarea {
            transition: all 0.3s ease;
            border-left: 3px solid #17a2b8;
            min-height: 120px;
        }
        
        textarea:focus {
            border-color: #138496;
            box-shadow: 0 0 0 0.2rem rgba(23, 162, 184, 0.25);
        }
        
        .character-counter {
            font-weight: bold;
        }
        
        .character-counter .current-count {
            color: #17a2b8;
        }
        </style>
	<script>
    // Add some interactive animations
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('malink');
        
        input.addEventListener('input', function() {
            if(this.value.length > 0) {
                this.classList.add('animate__tada');
                setTimeout(() => this.classList.remove('animate__tada'), 1000);
            }
        });
    });
</script>
</html>
