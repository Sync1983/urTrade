function helper(document){
  var doc;
  this.doc = document;
  
  
  this.ajax = function(url,params,success,error){    
    jQuery.ajax({                
                url: url,
                type: "POST",
                data: params,
                error: function(xhr,tStatus,e){
                  console.log("Ajax error: ",xhr,tStatus,e);
                  if(error)
                    error(xhr,tStatus,e);
                },
                success: function(data){
                  $(".preloader").removeClass("show");
                  if(success)
                    success(data);
                },
                beforeSend:	function(){ 
                  $(".preloader").addClass("show"); 
                }
    });	
    
  }
  
  return this;
}

document.helper = helper(document);

