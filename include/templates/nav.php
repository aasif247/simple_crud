<div style="border-bottom: 1px solid; border-color:#eee; padding-bottom: 30px; margin-bottom:30px;">
    <div class="float-left">
        <p>
            <a href="/index.php?task=report">All Students</a>
            |
            <a href="/index.php?task=add">Add new student</a>
            |
            <a href="/index.php?task=seed">Seed</a>
        </p>

    </div>

    <div class="float-right">
        <?php
        session_start();
        // if (!$_SESSION['loggedin']):
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true): // this code is working but don't figure it out
    
        ?>
        <a href="/auth.php">Login</a>
        <?php
        else:
        ?>
        <a href="/auth.php?logout=true">Logout</a>
        <?php
        endif;
        ?>
    </div>
    <p></p>
</div>