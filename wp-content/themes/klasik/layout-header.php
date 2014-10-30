                    <?php if(is_active_sidebar('maintop') ){ ?>
                    <div class="twelve columns">
                    	<div class="maintop-container">
                    		<?php if ( ! dynamic_sidebar( 'maintop' ) ){ } ?>
                        	<div class="clear"></div>
                        </div>
                    </div>
                    <?php } ?>
                    
                    <?php 
                    $sidebarposition = klasik_get_option( 'klasik_sidebar_position' ,'two-col-left'); 
                    
                    if(is_home()){
						$pid = get_option('page_for_posts');
					}else{
						$pid = '';
					}
                    $custom_fields = klasik_get_customdata($pid);
                    
                    $pagelayout = $sidebarposition;
                    
                    if(isset( $custom_fields['klasik_layout'][0] ) && $custom_fields['klasik_layout'][0]!='default'){
                        $pagelayout = $custom_fields['klasik_layout'][0];
                    }
                    
                    if($pagelayout!='one-col'){
                        $mcontentclass = "hassidebar";
						$contentclass = 'contentcol columns ';
						
                        if($pagelayout=="two-col-left"){
                            $mcontentclass .= " mborderright";
							$contentclass .= "positionleft";
                        }else{
                            $mcontentclass .= " mborderleft";
							$contentclass .= "positionright";
                        }
                    }else{
                        $mcontentclass = "twelve columns";
						$contentclass = '';
                    }
                    ?>
                    <section id="maincontent" class="<?php echo $mcontentclass; ?>">
                        <section id="content" class="<?php echo $contentclass; ?>">
                            
                            <?php if(is_active_sidebar('contenttop') ){ ?>
                            <div class="row">
                                <div class="twelve columns">
                                    <div class="contenttop-container">
                                        <?php if ( ! dynamic_sidebar( 'contenttop' ) ){ } ?>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            
                            
                            <?php 
								$nocont="";
								if(get_the_content()== "" && is_page() && !is_page_template()){$nocont="nocontent";} 
							?>
                            <div class="main <?php echo $nocont; ?>">
                           