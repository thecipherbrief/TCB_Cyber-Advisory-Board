var listingBlocks;
function load_validate() {
    var blocks = document.getElementsByClassName('wpt-form-textfield');


    for(var i = 0; i < blocks.length; i++){
        if(blocks[i].getAttribute("data-wpt-field-title") == "Article"){
            jQuery("<div id='" + blocks[i].id + "-text'></div>").insertAfter(document.getElementById(blocks[i].id));
            document.getElementById(blocks[i].id).addEventListener("keyup", function ( ) {
                listingBlocks = this.id;
                valueSearch = this.value;
                valueCase = "article";
                jQuery.ajax({
                    url: "/expert-validate",
                    method: 'POST',
                    dataType: "html",
                    data: {
                        "case": valueCase,
                        "value": valueSearch,
                    },
                    success: function ( data ) {
                        jQuery("#" + listingBlocks + "-text").html(data);
                    }});
            })};

        if(blocks[i].getAttribute("data-wpt-field-title") == "Expert Commentary For..."){
            jQuery("<div id='" + blocks[i].id + "-text'></div>").insertAfter(document.getElementById(blocks[i].id));
            document.getElementById(blocks[i].id).addEventListener("keyup", function ( ) {
                listingBlocks = this.id;
                valueSearch = this.value;
                valueCase = "commentary";
                jQuery.ajax({
                    url: "/expert-validate",
                    method: 'POST',
                    dataType: "html",
                    data: {
                        "case": valueCase,
                        "value": valueSearch,
                    },
                    success: function ( data ) {
                        jQuery("#" + listingBlocks + "-text").html(data);
                    }});
            })};
        var pos = blocks[i].getAttribute("name").search("recent-brif");
        if(pos > 0){
            jQuery("<div id='" + blocks[i].id + "-text'></div>").insertAfter(document.getElementById(blocks[i].id));
            document.getElementById(blocks[i].id).addEventListener("keyup", function ( ) {
                listingBlocks = this.id;
                valueSearch = this.value;
                valueCase = "tacrticle";
                jQuery.ajax({
                    url: "/expert-validate",
                    method: 'POST',
                    dataType: "html",
                    data: {
                        "case": valueCase,
                        "value": valueSearch,
                    },
                    success: function ( data ) {
                        jQuery("#" + listingBlocks + "-text").html(data);

                    }});
            });
        }

        var pos = blocks[i].getAttribute("name").search("articleexcerpt");
        if(pos > 0){
            jQuery("<div id='" + blocks[i].id + "-text'></div>").insertAfter(document.getElementById(blocks[i].id));
            document.getElementById(blocks[i].id).addEventListener("keyup", function ( ) {
                listingBlocks = this.id;
                valueSearch = this.value;
                valueCase = "article-excerpt";
                jQuery.ajax({
                    url: "/expert-validate",
                    method: 'POST',
                    dataType: "html",
                    data: {
                        "case": valueCase,
                        "value": valueSearch,
                    },
                    success: function ( data ) {
                        jQuery("#" + listingBlocks + "-text").html(data);

                    }});
            });
        }
    }}
function init_validation() {
    document.getElementsByClassName('js-wpt-repadd')[0].addEventListener('click', function () {
        setTimeout(load_validate, 500);
    });
}
function set_art( data ) {
    var decoded = jQuery("#" + listingBlocks).html(data).text();
    document.getElementById(listingBlocks).value  = decoded;
    jQuery("#" + listingBlocks + "-text").html("");
}
document.addEventListener("DOMContentLoaded", load_validate);
document.addEventListener("DOMContentLoaded", init_validation);


