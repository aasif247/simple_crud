<div style="border-bottom: 1px solid; border-color:#eee; padding-bottom: 30px; margin-bottom:30px;">
    <div class="float-left">
        <p>
            <a href="/index.php?task=report">All Students</a>
            |
            <?php if(hasPrivilege() ): ?>

                <a href="/index.php?task=add">Add New Student</a>    
            
            <?php endif; ?>

            
            <?php
			if ( isAdmin() ):
			?>
            |
            <a href="/index.php?task=seed">Seed</a>
            <?php
			endif;
			?>
        </p>

    </div>

    <div class="float-right">
        <?php
        // if (!$_SESSION['loggedin']):
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true): // this code is working but don't figure it out
    
        ?>
        <a href="/auth.php">Login</a>
        <?php
        else:
        ?>
        <a href="/auth.php?logout=true">Logout (<?php echo $_SESSION['role'] ?>)</a>
        <?php
        endif;
        ?>
    </div>
    <p></p>
</div>