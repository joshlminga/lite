<?= ((method_exists('CoreField', 'theme_Head')))? $this->CoreField->theme_Head($load_style=null):''; ?>

<?php //$this->CoreLoad->queueStyle(['styles.css,boostrap.min.css',array(),time(),'theme_name'); ?>
<?php //$this->CoreLoad->queueScript('styles.css',['async','defer'],time(),'theme_name'); ?>
<?php //$this->CoreLoad->queueImage('home.jpeg',["title" => "welcome home","tags" => "home"],'cache':true,'theme_name'); ?>
<link href="<?php //$this->CoreLoad->queueAssets('styles.css','theme_name'); ?>">
