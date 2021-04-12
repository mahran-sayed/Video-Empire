function likeVideo(button,videoId){
    console.log(button);
    axios.post("ajax/videoLike.php","videoId="+videoId).then((data)=>{
        
        console.log(data.data);
        let likeimg = document.querySelector(".likeButton img");
        let dislikeimg= document.querySelector(".dislikeButton img");
        let like = document.querySelector(".likeButton .text");
        let dislike= document.querySelector(".dislikeButton .text");
        like.classList.add("active");
        dislike.classList.remove("active");
        console.log(like.textContent,dislike.textContent)
        updateLikesValues(like,data.data.likes);
        updateLikesValues(dislike,data.data.dislikes);
        console.log(dislike,data.data.dislikes);
        if(data.data.likes < 0 ){
            likeimg.setAttribute("src","assets/images/icons/thumb-up.png");
        }else{
            likeimg.setAttribute("src","assets/images/icons/thumb-up-active.png");
        }
        dislikeimg.setAttribute("src","assets/images/icons/thumb-down.png");


    }).catch((e)=>{
        console.log(e);

    })
}


function dislikeVideo(button,videoId){
    console.log(button);
    axios.post("ajax/videoDislike.php","videoId="+videoId).then((data)=>{
        
        console.log(data.data);
        let likeimg = document.querySelector(".likeButton img");
        let dislikeimg= document.querySelector(".dislikeButton img");
        let like = document.querySelector(".likeButton .text");
        let dislike= document.querySelector(".dislikeButton .text");
        like.classList.remove("active");
        dislike.classList.add("active");
        console.log(like.textContent,dislike.textContent)
        updateLikesValues(like,data.data.likes);
        updateLikesValues(dislike,data.data.dislikes); 
        
        if(data.data.dislikes < 0 ){
            dislikeimg.setAttribute("src","assets/images/icons/thumb-down.png");
        }else{
            dislikeimg.setAttribute("src","assets/images/icons/thumb-down-active.png");
        }
        likeimg.setAttribute("src","assets/images/icons/thumb-up.png");

    }).catch((e)=>{
        console.log(e);

    })
}

function updateLikesValues(element,num){
    let likesCountVal = element.textContent || 0;
    element.textContent = (parseInt(likesCountVal)+parseInt(num));
}