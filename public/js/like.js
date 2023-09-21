$(document).ready(function () {

    $(".like-button-commentaire").click(function () {
        let commentId = $(this).data("comment-id");
        let likeButton = $(this); 

        console.log(likeButton);
        $.ajax({
            type: "POST",
            url: "/like/commentaire/" + commentId,
            success: function (data) {
                
                likeButton.find(".like-count").text(data.totalLikes); 
                if(data.likedByUser === true){
                    likeButton.find("path").addClass("like");
                    likeButton.find("path").removeClass("dislike");

                }else if(data.likedByUser === false){
                    likeButton.find('path').addClass('dislike');
                    likeButton.find('path').removeClass('like');


                }
                console.log(data.likedByUser);
                
            },
            error: function () {
                alert("Une erreur s'est produite lors du traitement de votre demande.");
            },
        });
    });
});
