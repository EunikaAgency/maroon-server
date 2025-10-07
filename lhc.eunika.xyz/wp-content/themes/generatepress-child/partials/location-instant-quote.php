<div id="instant-quote">
    <div class="spacer"></div>
    <div class="container">
        <center>
            <h2><?php echo $args['heading'] ?></h2>
            <p><?php echo $args['sub_heading'] ?></p>
        </center>
        <div class="row">
            <div class="col-md-6 p-0">
                <div class="column1">
                    <div class="bg-overlay"></div>
                    <div class="spacer-inner"></div>
                    <div class="content-inner">
                    <a class="video-play-button" href="https://www.youtube.com/watch?v=Tii5ewXdBbU"> <i class="fa fa-play"></i> </a>
                    </div>
                    <div class="spacer-inner"></div>
                </div>
            </div>
            <div class="col-md-6 p-0">
                <div class="column2">
                    <div class="quote-form">
                        <h3>Get Your Instant Quote</h3>
                        <?php
                            echo do_shortcode('[wpforms id="5493"]');
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="spacer"></div>
</div>

<style>
    .column2{
        background-color: #13287d;
        height: auto;
        padding: 30px
    }
    .column1{
        background-image:url(https://cdn-kicmn.nitrocdn.com/qsmLuGXwNbMBYnrxzisZvAhVVOhOZPjt/assets/images/optimized/rev-fe3ad50/londonhousecleaners.co.uk/wp-content/uploads/2023/09/h1_video_bg.jpg);
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
        height: 100%;
        align-content: center;
        align-items: center;
    }
    .bg-overlay{
        height: 100%;
        width: 100%;
        top: 0;
        left: 0;
        background-color: #279e64;
        opacity: .5;
        position:absolute;
    }
    .spacer-inner{
        height: 150px;
    }
    .quote-form{
        background-color: #fff;
        margin: 5px;
        padding: 30px;
    }
    h3{
        font-family: "Poppins", Sans-serif;
        font-size: 28px;
        font-weight: 600;
        color: #13287d;
        text-align: center;
    }
    .content-inner{
        justify-content: center;
        display: flex;
        align-items: center;
    }
    .video-play-button{
        position: relative;
        display: inline-flex;
        width: 95px;
        height: 95px;
        align-items: center;
        justify-content: center;
        background: #fff;
        border-radius: 50%;
    }
    .icon-container{
        display: flex;
        flex-wrap: wrap;
        margin-left: -20px;
    }
  
    #wpforms-5493-field_51 label{
        font-size: 16px;
        font-weight: normal;
        line-height: 22px;
    
}
#wpforms-submit-5493{
    width: 100%;
    &:hover{
        background-color:#28a745;
    }
}
@media screen and (max-width: 768px){
    /* #wpforms-5493-field_51{
    width: 100% !important;
    display: flex;
    }
    #wpforms-5493-field_51 label{
        aspect-ratio: 100/100;
        span{
        font-size: 12px !important;
        }
    } */
    #wpforms-5493-field_44-container{
      width: 100%;
      float: none !important;
      clear: none;
    }
    #wpforms-5493-field_46-container{
      width: 100%;
      float: none !important;
      clear: none;
      margin-left: 0px;
    }
}
</style>