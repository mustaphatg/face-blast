const home_loading = "<p> class=' mt-5 text-center spa-loading'>"
				+"<span class='spinner spinner-border text-primary'>"
				+"</span></p>";
				

function vote(th){
	var id = th.getAttribute("post-id") //post id
	var contestant = th.getAttribute("contestant") //contestant 1 or 2
	var compete_div = $(".compete-"+id) //compete div
	var height = compete_div.css("height") //div's height
	var content = compete_div.html(); //get content in case of error
	
	compete_div.css("height", height) //set height
	compete_div.addClass("turn-grey") //set background to grey
	compete_div.html(loading) //change content to loading
	
	
	$.post("/vote", {"post_id":id, "contestant": contestant}, function(v,s){
		if(v == ""){
			compete_div.html(content)
			toast("You've choosed one earlier. ")
		}
		else if(v == "Something went wrong."){
			compete_div.html(content)
			toast(v)
		}
		else{
			compete_div.html(v)
		}
		//always
		compete_div.removeClass("turn-grey") //set background back to white
	})
	.fail(function(s){
		compete_div.html(content)
		compete_div.removeClass("turn-grey") //set background back to white
		toast("Could not submit your vote.")
		//alert(s.responseText)
	})
	
}

//localforage.clear((e,v) => alert(5))


function like(th){
	//get id
	var id = $(th).attr("post-id");
	
	//query the local storage
	localforage.getItem("post-"+id, function(e,v){
		// if post exist, return to terminate function
		if(v){ //post exist, v is not null
			if(window.A) { A.toast("You cant like a post twice."); }
			else{ toast("You cant like a post twice."); }
			return;
		}
		else{ //post does not exist
			//set post
			localforage.setItem("post-"+id, "yes", (e,v)=> {})
			
				//number of likes container
				var lk = $("#like-"+id) 
				
				if(lk.text() == ""){
					var t = 0
				}else{
					t = parseInt(lk.text())
				}
				
				t = t + 1
				lk.text(t)
				
				$(th).addClass("text-white bg-primary")
				$(th).attr("disabled", "disabled")
				
				$.post("/like", {"post-id":id})
				.fail(function(e){
					toast("Unable to submit your like.")
					lk.text(lk.text() -1)
					$(th).removeClass("text-white bg-primary")
					$(th).removeAttr("disabled")
					// alert(e.responseText)
				})
				
		} // end else : post does not exist
		
	}) //end query the localstorage
	
}



function comment(th){
	var id = th.getAttribute("post-id")
	var num_of_comment = $("#num-of-comment-"+id) //span that houses the number of comments, to be updated if user comment
	var postt = $(".compete-"+id) //get post and change content on comment submitted
	
	var div = $('.comment-div')
	var con = div.html()
	var bd = $("#comment-body")
	
	if(bd.val() == ""){
		toast("Comment is empty.")
		return;
	}
	
	div.html(loading)
	
	$.post("/comment", {"post_id":id, "body": bd.val()}, function(v,s){
		if(s == "success"){
			
			var username = v.charAt(0).toUpperCase() + v.substr(1)
			
			var c = "<li class='list-group-item d-flex flex-column'>"
					+ "<span class=' hv text-primary'>" + username + "</span>"
					+ "<span class=''>" + bd.val() + "</span>"
					+ "</li>"
			$("#post-comment").append(c)
			
			//update the number of comments in home.php
			let com_value = num_of_comment.text()

			if(com_value.length == 2){
				num_of_comment.text("1")
			}else{
				com_value = parseInt(com_value)
				let vv = com_value + 1
				num_of_comment.text(vv)
				
			}
			//end of update
			
			if(window.A) { A.toast("Your comment has been submitted.") }
			
		}
	})
	.fail(function(e){
		//alert(e.responseText)
		toast("Couldn't submit your comment")
	})
	.always(function(){
		div.html(con)
	})
	
}


function deletePost(th){
	var id = th.getAttribute("post-id")
	var post = $(".compete-"+id)
	th.innerHTML = "Deleting..."

	$.get("/delete/"+id, function(v,s){
		if(s == "success"){
			post.fadeOut("fast")

		}
	})
	.fail(function(e){
		//alert(e.responseText)
		toast("An error occurred")
	})

}


