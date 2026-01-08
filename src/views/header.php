<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'Guestbook'; ?></title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; max-width: 800px; margin: 0 auto; padding: 20px; background: #f4f4f4; }
        nav { background: #333; color: #fff; padding: 10px 20px; border-radius: 4px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
        nav a { color: #fff; text-decoration: none; font-size: 0.9em; margin-left: 15px; }
        .entry { background: #fff; padding: 15px; margin-bottom: 10px; border-left: 5px solid #28a745; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .entry-meta { font-size: 0.8em; color: #666; margin-bottom: 5px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="email"], input[type="password"], textarea { 
            width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; 
        }
        input.error, textarea.error { border-color: #dc3545; background-color: #fff8f8; }
        .error-msg { color: #dc3545; font-size: 0.85em; margin-top: 5px; display: block; }
        button { background: #28a745; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #218838; }
        footer { margin-top: 40px; padding-top: 20px; border-top: 1px solid #ccc; font-size: 0.9em; color: #777; }
        .alert { padding: 10px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb; margin-bottom: 20px; border-radius: 4px; }
    </style>
</head>
<body>
    <nav>
        <div class="nav-brand"><a href="index.php" style="margin:0; font-weight:bold; font-size:1.1em;">📝 Guestbook</a></div>
        <div class="nav-links">
            <?php if (Auth::isLoggedIn()): ?>
                <span>Welcome, <strong><?php echo e(Auth::getUsername()); ?></strong></span>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            <?php endif; ?>
        </div>
    </nav>
    <h1><?php echo $page_title ?? 'Guestbook'; ?></h1>