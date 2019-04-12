<?php
/*
 * Template Name:模板-留言
 */
?>
<?php
 if('POST' == $_SERVER['REQUEST_METHOD']){
     //get_template_part('template-parts/activity','part');
     
     
        global $post, $current_user; //for this example only :)
        $commentdata = array(
            //'comment_post_ID' => $post->ID, // to which post the comment will show up
            //'comment_type' => '', //empty for regular comments, 'pingback' for pingbacks, 'trackback' for trackbacks
            'comment_parent' => 0, //0 if it's not a reply to another comment; if it's a reply, mention the parent comment ID here
            'user_id' => $current_user->ID, //passing current user ID or any predefined as per the demand
	);
        
        if(mb_strlen($_POST['user_name']) > 100 || mb_strlen($_POST['comment_title']) > 100 || 
           mb_strlen($_POST['user_address']) > 100 || mb_strlen($_POST['user_msg']) > 100){
            js_location(home_url(), "字数过多！");
        }        
	//Insert new comment and get the comment ID
	$comment_id = wp_new_comment( $commentdata );
	if($comment_id){
            add_comment_meta( $comment_id, 'name', $_POST['user_name'] );
            add_comment_meta( $comment_id, 'number', $_POST['user_phone'] );
            add_comment_meta( $comment_id, 'theme', $_POST['comment_title'] );
            add_comment_meta( $comment_id, 'email', $_POST['user_email'] );
            add_comment_meta( $comment_id, 'address', $_POST['user_address'] );
            add_comment_meta( $comment_id, 'content', $_POST['user_msg'] );
            js_location(home_url(), "感谢咨询，我们会尽快安排工作人员与您联系，谢谢！"); 
	}else{
            js_location(home_url(), "提交失败，请重试！");  
	}         
 }   
?>
<?php get_header(); ?>        
        <div class="v2_banner">

            <div id="slidershow" class="carousel slide">

                <!--<ol class="carousel-indicators">
                    <li class="active" data-target="#slidershow" data-slide-to="0"></li>
                </ol>-->

                <div class="carousel-inner">
                    <?php 
                        $banners = rwmb_meta('page_custom_banners');
                        foreach ($banners as $item):
                    ?>
                    <div class="item active">
                            <img src="<?php echo $item['full_url']; ?>" alt="">
                    </div>
                     <?php endforeach; ?>           

                </div>

            </div>

        </div>

        <section class="sidebar-v2__section">

            <div class="section__head">
                <div class="navbar sidebar-v2">
                    <div class="container-fluid" id="sidebar-v2__accordion">
                        <div class="navbar-header   ">

                            <h1 class="dropdown-toggle sidebar-v2__h1 btn " data-toggle="collapse" data-target="#sidebar-v2__list3" data-parent="#sidebar-v2__accordion">
                                <button type="button" disabled="disabled"></button>
                                <span>
                                    <?php echo $post->post_title; ?>
                                </span>
                            </h1>

                        </div>

                        <div class="panel">	

                            <div class="collapse navbar-collapse" id="sidebar-v2__list2">

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </section>

        <div class="met_clear"></div>

        <article class="sidebar-v2__article">
            <div class="met_article">


                <div id="feedback">
                    <form enctype='multipart/form-data' method='POST' id="msg_form" class="ui-from" name='myform' action=''>
                        <div class="v52fmbx">
                            <h3 class="v52fmbx_hr"><?php echo $post->post_title; ?></h3>

                            <dl>
                                <dt class="ftype_select">留言主题</dt>
                                <dd class="ftype_input">
                                    <div class="fbox">
                                        <input name='comment_title' type='text' placeholder='' data-required=1 />
                                    </div>
                                    <span class="tips"></span>
                                </dd>
                            </dl>

                            <dl>
                                <dt class="ftype_select">姓名</dt>
                                <dd class="ftype_input">
                                    <div class="fbox">
                                        <input name='user_name' id="user_name" type='text' placeholder='' data-required=1 />
                                    </div>
                                    <span class="tips"></span>
                                </dd>
                            </dl>

                            <dl>
                                <dt class="ftype_select">联系方式</dt>
                                <dd class="ftype_input">
                                    <div class="fbox">
                                        <input name='user_phone' id="user_phone" type='text' placeholder='' data-required=1 />
                                    </div>
                                    <span class="tips"></span>
                                </dd>
                            </dl>

                            <dl>
                                <dt class="ftype_select">Email</dt>
                                <dd class="ftype_input">
                                    <div class="fbox">
                                        <input name='user_email' id="user_email" type='text' placeholder='' data-required=1 />
                                    </div>
                                    <span class="tips"></span>
                                </dd>
                            </dl>

                            <dl>
                                <dt class="ftype_select">地址</dt>
                                <dd class="ftype_input">
                                    <div class="fbox">
                                        <input name='user_address' type='text' placeholder=''  />
                                    </div>
                                    <span class="tips"></span>
                                </dd>
                            </dl>

                            <dl>
                                <dt class="ftype_select">留言内容</dt>
                                <dd class="ftype_textarea">
                                    <div class="fbox">
                                        <textarea name='user_msg' id="user_msg" data-required=1 placeholder=''></textarea>
                                    </div>
                                    <span class="tips"></span>
                                </dd>
                            </dl>

                            <dl class="noborder">
                                <dt>&nbsp;</dt>
                                <dd>
                                    <input type="submit" name="submit" value="提交信息" class="submit" />
                                </dd>
                            </dl>
                        </div>
                    </form>
                    <!--</div>-->
                    <!--</div>-->
                    <div class="clear"></div>
                </div>
                <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
                <script type="text/javascript">
                    $("#msg_form").submit(function(){
                        var error = "";
                        
                        if(!$("#user_name").val()){
                            error += "-请输入您的姓名"+"\n";
                        }
                        if(!$("#user_phone").val()){
                            error += "-请输入您的联系方式！"+"\n";
                        }
                        if(!$("#user_msg").val()){
                            error += "-请输入留言内容！"+"\n";
                        }
                        var reg = new RegExp(/^1[0-9]{10}$/);
                        if(!reg.test($("#user_phone").val())){
                            error += "-您输入的手机号有误！"+"\n";                    
                        }
                        if($("#user_email").val()){                            
                            var reg = new RegExp(/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/); 
                            if(!reg.test($("#user_email").val())){
                                error += "-您输入邮箱格式有误！"+"\n";                    
                            }
                        }
                        if(error != ""){
                            alert(error);
                            return false;
                        }                        
                        
                    });
                </script>
            </div>
        </article>
        <div class="met_clear"></div>
    </section>
    <?php get_footer(); ?>