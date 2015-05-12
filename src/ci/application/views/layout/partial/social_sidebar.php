<div class="social-sidebar">

    <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
        <li class="" ><a href="#red" data-toggle="tab"><i class="fa fa-2x fa-user"></i> </a></li>
        <li class="active" id="messageTab" ><a href="#orange" data-toggle="tab"><i class="fa fa-2x fa-comments"></i></a></li>
        <li><a href="#yellow" data-toggle="tab"><i class="fa fa-2x fa-globe"></i></a></li>
    </ul>

    <div class="tab-content">
        <textarea class="message userMessage" id="receiver_<?php echo $userId ?>" rows="5"></textarea>
        <div class="userMessageSuccess" style="display: none;"></div>
        <div class="userMessageError" style="display: none;"></div>
    </div>
</div>