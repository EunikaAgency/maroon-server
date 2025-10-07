<div class="container faq px-4 px-lg-0 py-5">
    <div class="row">
        <div class="col-md-5">
            <img src="<?php echo $args['image']['url'] ?>">
        </div>
        <div class="col-md-7 pt-5 pt-md-0">
            <div class="sub-heading text-center text-sm-left">
                <?php echo $args['subheading'] ?>
            </div>
            <h2 class="text-center text-sm-left"><?php echo $args['heading'] ?></h2>

            <div class="container mt-5">
                <div id="accordion">

                    <?php foreach ($args['faq_accordion'] as $key => $_faq) : ?>
                        <div class="accord card collapsed"data-toggle="collapse" data-target="#collapse<?= $key ?>">
                            <div id="question-container" class="card-header" id="heading<?= $key ?>">
                                <a class="faq-question mb-0">
                                <?php echo $_faq['question'] ?>
                                    <!-- <button class="accord btn btn-link"  aria-expanded="true" aria-controls="collapseOne">
                                    </button> -->
                                </a>
                            </div>

                            <div id="collapse<?= $key ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="card-body">
                                    <?php echo $_faq['answer'] ?>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>


                </div>

            </div>
        </div>

    </div>
</div>

<style>
.active{
    background-color: red;
}
.accord{
    width: 100%;
    h5{
    font-size: 22px;
    }
    #question-container{
        padding-right: 70px;
    }
}
.accord:after {
        content: '\002B';
        font-family: "Font Awesome 5 Pro";
        font-size: 16px;
        position: absolute;
        transform: translate(5px, 5px);
        right: 0px;
        width: 46px;
        height: 46px;
        line-height: 46px;
        text-align: center;
        color: rgb(19, 40, 125);
        transition: all 300ms ease 0s;

       
}

/* c */
.accord:not(.collapsed):after{
    content: "\2212";
    background-color: rgb(39, 158, 100);
    color: rgb(255, 255, 255);
    transform: translate(-10px, 5px);
    box-shadow: rgba(39, 158, 100, 0.5) 0px 10px 30px 0px;
}

.faq-question{
    font-size: 22px;
    font-weight: 600;
}

</style>