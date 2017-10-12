<div class="pbpanel-container">
	<div class="pbpanel-column pbpanel-column-sticky">
		<div class="pbpanel-box">
			<nav class="pbpanel-navigation">
				<ul>
					<li><a href="<?php echo admin_url('admin.php?page=pbpanel-notebook'); ?>" class="pbpanel-icon-nav-1 <?php if ($_REQUEST['page'] == 'pbpanel-notebook'): echo 'active'; endif; ?>"><?php echo 'Analyst notebook'; ?></a></li>
					<li><a href="<?php echo admin_url('admin.php?page=page-cipher-exclusive'); ?>" class="pbpanel-icon-nav-1 <?php if ($_REQUEST['page'] == 'page-cipher-exclusive'): echo 'active'; endif; ?>"><?php echo 'Cipher exclusive'; ?></a></li>
					<li><a href="<?php echo admin_url('admin.php?page=page-flash-traffic'); ?>" class="pbpanel-icon-nav-1 <?php if ($_REQUEST['page'] == 'page-flash-traffic'): echo 'active'; endif; ?>"><?php echo 'Flash traffic'; ?></a></li>
					<li><a href="<?php echo admin_url('admin.php?page=page-brief-features'); ?>" class="pbpanel-icon-nav-1 <?php if ($_REQUEST['page'] == 'page-brief-features'): echo 'active'; endif; ?>"><?php echo 'Brief features'; ?></a></li>
					<li><a href="<?php echo admin_url('admin.php?page=page-tech-cyber'); ?>" class="pbpanel-icon-nav-1 <?php if ($_REQUEST['page'] == 'page-tech-cyber'): echo 'active'; endif; ?>"><?php echo 'Tech / Cyber'; ?></a></li>
				</ul>
			</nav>
		</div>
	</div>