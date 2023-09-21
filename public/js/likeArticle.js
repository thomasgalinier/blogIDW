$(document).ready(function () {

    $(".like-button-article").click(function () {
        let articleId = $(this).data("article-id");
        let likeButton = $(this); 

        
        $.ajax({
            type: "POST",
            url: "/like/article/" + articleId,
            success: function (data) {
                
                likeButton.find(".like-count").text(data.totalLikes) ; 
                if(data.likedByUser === true){
                    likeButton.find("path").addClass("like");
                    likeButton.find("path").removeClass("dislike");

                }else if(data.likedByUser === false){
                    likeButton.find('path').addClass('dislike');
                    likeButton.find('path').removeClass('like');


                }
                
                
            },
            error: function () {
                alert("Une erreur s'est produite lors du traitement de votre demande.");
            },
        });
    });
});
