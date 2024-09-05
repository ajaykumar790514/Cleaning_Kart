<!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
       
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar" style="max-width:100% !important;">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        
                    <?php foreach($shop_menus as $menu)
                    { 
                        foreach($all_menus as $all) 
                        {
                            $menu_flag ='0';
                            if($menu->id == $all->parent)
                            {
                                $menu_flag ='1';
                                break;
                            }
                        }
                        if($menu_flag == '1')
                        {
                            $url = $menu->url.'/'.$menu->id;
                        }
                        else if($menu_flag == '0')
                        {
                            $url = $menu->url;
                        }
                    ?>
                        <li>
                            <a href="<?php echo base_url($url); ?>"><i class="<?= $menu->icon_class; ?>"></i><span class="hide-menu"><?= $menu->title; ?></span></a>
                        </li>
                        <?php } ?>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>

        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->