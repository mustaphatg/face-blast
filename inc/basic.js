
document.body.style.backgroundColor = "grey"

const loading = "</div><p class='mt-5 text-center spa-loading'>"
				+"<span class='spinner spinner-border text-primary'>"
				+"</span></p>"

//get user notifications
//call function everytime spa is fully loaded
function getNoty(){
	var n = $(".noty-num")
	$.get("/num-notifications", function(v,s){
		n.text(v)
	})
}


/* open sidebar */
function op(){
	var s = $(".sidebar")
	var o = $(".overlay")
	s.toggleClass("active")
	o.toggleClass("active")
}

function toast(mess){
//	if(window.A){ A.toast(mess) }
	
		$(".toast-message").text(mess)
		$("#tst").css({"margin-bottom" : "0px"})
	
	
}

/*  close toast */
function ctoast(mess){
	$("#tst").css({"margin-bottom" : "-70px"})
}


/* show spa */
function showSpa(ti = null){
	var s = $(".spa")
	//display title
	$("#spa-title").text(ti)
	
	//show
	s.fadeIn("slow")
	$(".m-backdrop").css("display" ,"block")
}

/* hide spa */
function hideSpa(){
	var s = $(".spa")
	s.fadeOut("slow")
	

	$(".m-backdrop").css("display" , "none")
				
	$(".spa .page").html(loading)
	
}


function closeImageSpa(){
		$(".m-backdrop").css("display" , "none")
}



//to show spa for image
function goImage(th){
	
	var im_spa = $(".image-spa")
	im_spa.fadeIn("slow")
	
	var im = document.createElement("img")
	im.setAttribute("class", "mx-auto d-block img-fluid")
	im.setAttribute("style", "width:95%; border-radius:5px")
	im.src = th.src
	
	$(".m-backdrop").css("display" , "block")
	
	$(".image-spa .page").html(im)
	
}




/* to start spa for post, profile*/
function go(th){
	var link = th.getAttribute("link")
	var title = th.getAttribute("title")
	
	//if there is link
	if(link)
	{
		showSpa(title)
		
		$.get("/"+link, function(v,s){
			if(s == "success")
			{
				$(".spa .page").html(v)
				getNoty()
			}
		})
		.fail(function(e){
			hideSpa()
			toast("Network Error. Try again.")
			//alert(e.responseText)
		})
		
	}
	else showSpa(title) //if there z no link
	
} //end spa for post,profile code


/* 
 
 post form codes
*/
var post_images = [] //store all selected
/* post image selection */
function choosePostImage(){
	var inp = document.querySelector("#post-image-input").files[0]
	
	if(post_images.length == 4){
		toast("Maximum image allowed is 4.")
		return ;
	}
	
	if(! inp.type.startsWith("image/")){
		toast("Image type not supported.")
		return;
	}
	
	var new_img = document.createElement("img")
	new_img.src = URL.createObjectURL(inp)
	new_img.load = function(){
		URL.revokeObjectURL(new_img.src)
	}
	
	var prev_box = document.querySelector(".post-image-prev")
	prev_box.appendChild(new_img)
	
	//insert file into post_images array
	post_images.push(inp)
}


/* send post form */
function sendPostForm(bt){
	var form = document.querySelector("#post-form")
	form.addEventListener("submit", function(event){
		event.preventDefault()
	})
	
	if(form.body.value == "" && post_images.length == 0){
		toast("There is nothing to post.")
		return;
	}
	
	var type = form.type.value
	var body = (form.body.value || "")

	var fd = new FormData()
	fd.append("type", type)
	fd.append("body", body)

	
	for(let i =0; i < post_images.length; i++){
		fd.append("image[]", post_images[i])
	}
	
	bt.innerHTML = "Posting..." //set text to posting...
	
	$.ajax({
		url : "/add-post",
		contentType : false,
		processData : false,
		data : fd,
		type : "post",
		success : function(v){
			if(v == "ok"){ location.href = "/"}
			else { toast(v); 	bt.innerHTML = "POST" }
		},
		error : function(e){
			toast("Network Error")
			//alert(e.responseText)
		}
		
	})
	
}

// end post form code





/* challenge form code */

//after choosing a challenge image
function challengeImage(th, img){
	var inp = th.files[0]

	if(! inp.type.startsWith("image/")){
		toast("Image type not supported")
		return
	}

	var g = document.querySelector("#"+img)
	$(g).css({
		"height": "150px",
		"width": "100%",
		"border-radius" : "2px",
		"display" : "block",
		"margin-bottom" : "4px",
		"object-fit" : "cover",
		"object-position" : "50% 50%"
	})
	g.src = URL.createObjectURL(inp)
	
}


//before submitting challenge form
function checkChallenge(th){

	if(th.body.value == ""){ toast("Post body is required"); return false}
	if(th.contestant1.value == ""){ toast("The first contestant field is empty."); return false}
	if(th.contestant2.value == ""){ toast("The second contestant field is empty."); return false}
	if(! th.contestant1_image.files[0] ){ toast("Add an image that belongs to the first contestant"); return false}
	if(! th.contestant2_image.files[0] ){ toast("Add an image that belongs to the second contestant"); return false}
	
}

//end challenge form code



//top nav
$(window).scroll(function(){
		
	if($(window).scrollTop() >= 3){
		$("#top").removeClass("top")
	}else{
		$("#top").addClass("top")
	}
	
})


// onload
$(function(){

	$("#top-clicker").click(function(){
		$("#top").removeClass("top")
	})
	
	$("#spa-closer").click(function(){
		hideSpa()
	})
	
	$("#image-spa-closer").click(function(){
		$(".image-spa").fadeOut("slow")
	})
	
	
	$("#side-bar-closer").click(function(){
		op()
	})	
	
})





document.body.style.backgroundColor = "grey"