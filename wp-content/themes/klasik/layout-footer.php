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
						?>
						
                        		<div class="clear"></div>
                            </div><!-- main -->
                            
                            <?php
							if(is_active_sidebar('contentbottom') ){ 
							?>
							<div class="row">
								<div class="twelve columns">
                                    <div class="contentbottom-container">
                                        <?php if ( ! dynamic_sidebar( 'contentbottom' ) ){ }?>
                                        <div class="clear"></div>
                                    </div>
                                </div>
							</div>
							<?php 
							}
							?>
                            <div class="clear"></div>
                        </section><!-- content -->
                        
                        <?php if($pagelayout!='one-col'){ ?>
                        
                        <aside id="sidebar" class="sidebarcol columns <?php if($pagelayout=="two-col-left"){echo "positionright";}else{echo "positionleft";}?>">
                            <?php get_sidebar();?>  
                        </aside><!-- sidebar -->
                        
                        <?php } ?>
                        <div class="clear"></div>
                        </section><!-- END #maincontent -->
                        
                        <?php if(is_active_sidebar('mainbottom') ){ ?>
                        <div class="twelve columns">
                        	<div class="mainbottom-container">
                           		<?php if ( ! dynamic_sidebar( 'mainbottom' ) ){ } ?>
                            	<div class="clear"></div>
                            </div>
                        </div>
                        <?php } ?>
                        
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div><!-- END #outermain -->
        <!-- END MAIN CONTENT -->