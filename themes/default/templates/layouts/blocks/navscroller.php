<nav id="shortnav" >

   <ul>
       
       <li><a href="#intro"><span class="nav-dot"></span><span class="nav-label">Introduction</span></a></li>

       <?php foreach ($nav as $post): ?>
           
           <li><a href="#<?= $post->slug ?>"><span class="nav-dot"></span><span class="nav-label"><?= $post->name ?></span></a></li>

       <?php endforeach; ?>

       <li><a href="#categories"><span class="nav-dot"></span><span class="nav-label">Rubriques</span></a></li>

   </ul>

</nav>