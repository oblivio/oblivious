console.log('add page');

$.blockUI.defaults.message = "";
//add-image-button
//execute callback when the page is ready:
$( document ).ready(function() {
	
	$("#clear-blackbook-button").on("click",function(){
		
			oblivious.blackbookClear();
		
	});

// Handler for .ready() called.
	// unblock when ajax activity stops 
	var oblivious_viewdata = {
		'clientsidecrypto':false,
		'categories':[],
		'togglecrypto':null,
		'setAddProperty':null,
		'newentry':{
			'text':'',
			'imgdata':'',
			'pwd':'',
			'expiration':'never',
			'category':'',
			'meta':{}
		}
	};
	
	oblivious_viewdata.togglecrypto = function(){
		if(oblivious_viewdata.clientsidecrypto == true){
			oblivious._disableClientCrypto();
			oblivious_viewdata.clientsidecrypto=false;
		}else{
			oblivious._enableClientCrypto();
			oblivious_viewdata.clientsidecrypto=true;
		}
	};
	oblivious_viewdata.setAddProperty = function(){
		var id = $(this).attr('id');
		switch(id){
		case "entry-expiration":
			oblivious_viewdata.newentry.expiration = $(this).val();
			break;
		case "entry-password":
			oblivious_viewdata.newentry.pwd = $(this).val();
			break;
		case "entry-text":
			oblivious_viewdata.newentry.text = $(this).val();
			break;
		case "addentry-category":
			oblivious_viewdata.newentry.category = $(this).val();
			break;
		}
	};
	rivets.bind($('#oblivious_addentry'), {
		viewdata: oblivious_viewdata
	});
	$.getJSON('/code/oblivious/api/list/categories/',function(data){
		oblivious_viewdata.categories = data.Categories;
	});
	
	oblivious._onchange('addimage-input',function(){
		var imgData = String(this);
		oblivious_viewdata.newentry.imgdata = imgData;
	});
	document.getElementById('decode-input').onchange = function(input) {
		var file    = document.getElementById('decode-input').files[0];
		if ( file ) {
	        var FR= new FileReader();
	        FR.onload = function(e) {
	        	var password = prompt('Enter password (leave empty if none)');
	        	
				GhostPixels.decode(password,e.target.result).then(function(decodedMessage){
					
					$("#encodedinvite-input").val(decodedMessage);
					
	        	});
	        	
	        };       
	        FR.readAsDataURL( file );
	    }
	};
	$("#submit-invite-button").on("click",function(){
		oblivious._processInvite('#invite-status');
			$("#inviteform")[0].reset();
	});
	$("#metadata_entry").on("change",function(){
		var tmpJSON = $(this).val();
		try{
			tmpJSON = JSON.parse(tmpJSON);
			for (var attrname in tmpJSON) { oblivious_viewdata.newentry.meta[attrname] = tmpJSON[attrname]; }
			$("#metadata_preview").val( JSON.stringify(tmpJSON,null,2) );
		}catch(e){
			console.log('not valid JSON');
		}
		
	});
	
	$("#submit-entry-button").on("click",function(){
		$.blockUI({ 
			onBlock:function(){
				console.log('obliviousdata',oblivious_viewdata.newentry);
				var d ={ data:String(oblivious_viewdata.newentry.text),
			             expire:oblivious_viewdata.newentry.expiration,
			             opendiscussion: 1,
			             category:oblivious_viewdata.newentry.category,
			             userkey:'',
			             imgdata:'',
			             containsimage:0
				     };
				for (var attrname in oblivious_viewdata.newentry.meta) { d[attrname] = oblivious_viewdata.newentry.meta[attrname]; }

				if(oblivious_viewdata.newentry.pwd != ''){
					//krypi-password
					//(newEntry,category,userKey,img_data){
					d.userkey = oblivious_viewdata.newentry.pwd;
				}
				if(oblivious_viewdata.newentry.imgdata != ''){
					d.imgdata = oblivious_viewdata.newentry.imgdata;
					d.containsimage = 1;
				}
				console.log('d',d);
				if(d.imgdata || d.userkey){
					console.log('krypi entry');
					oblivious.addKrypiEntry(d,function(){
						$.unblockUI();
					});
				}else{
					console.log('regular entry');
					oblivious.addEntry(d,function(){
						$.unblockUI();
					});
				}
				$('#addentryform')[0].reset();
			}}); 
		
	});
	$("#addentryform").on('reset',function(){
		oblivious._disableClientCrypto();
		oblivious_viewdata.clientsidecrypto=false;
	});
	$('#addentryform')[0].reset();
	
	
	
});
console.log('home page');
$.blockUI.defaults.message = "";
//execute callback when the page is ready:
$( document ).ready(function() {
  // Handler for .ready() called.
	var oblivious_data = {
			entries:[],
			freshload:true,
			showinvite:false,
			hasChanged:[],
			categories:[],
			subnav:{
				'categories':true,	
				'content':[],
				'active':'',
				'travel':null,
			}
	};
	oblivious_data.subnav.travel = function(){
		var cat = $(this).val();
		$.blockUI({ onBlock:function(){
			$.getJSON('/code/oblivious/api/list/entries/'+cat+'/',function(data){
				oblivious_data.entries = data.Entries;
				console.log('data.Entries',data.Entries);
				oblivious_data.subnav.active = cat;
				oblivious_data.freshload = false;
				oblivious_data.showinvite = false;
				$.unblockUI();
			});
		}
		} );
			
	};
	oblivious_viewentry_data = {
		'entries':[],
		'category':'',
		'contents':[],
		'_entryid':'',
		'password':''
	};
	
	rivets.bind($('#oblivious_entrylist'), {
		oblivious_data: oblivious_data
	});
	rivets.bind($('#subnav-home'), {
		oblivious_data:oblivious_data
	});
	rivets.bind($('#oblivious_viewentry'),{
		oblivious_viewentry_data: oblivious_viewentry_data
	});
	
	$.getJSON('/code/oblivious/api/list/categories/',function(data){
			oblivious_data.categories = data.Categories;
			oblivious_data.subnav.content = data.Categories;
//			oblivious_data.subnav.active = '(choose a category to begin...)';
	});
	$('body').on('click', '.oblivious-entry-button', function() {
	    // do something
		var entryID = $(this).attr('eid');
		console.log('entryID',entryID);
		$("#oblivious_entrylist").fadeOut();
		$("#oblivious_viewentry").fadeIn();
		//oblivious_viewentry_data
		oblivious_viewentry_data.password = '';
		oblivious_viewentry_data.category = '';
		oblivious_viewentry_data.entries = [];
		oblivious_viewentry_data._entryid = '';
		
		$.each(oblivious_data.entries,function(i,entry){
			if(entry.entryid == entryID){
				oblivious_viewentry_data.category = entry.category;
				oblivious_viewentry_data.entries = [entry];
				oblivious_viewentry_data._entryid = entry.entryid;
				
				$("#"+entry.entryid).parent("."+entry.category).parent().removeClass('has-changed');
				
				$("#view-entry-meta").val( JSON.stringify(entry.meta,null,2) )
				$.blockUI({ onBlock:function(){
					oblivious.getEntry(entry.entryid,entry.category,function(){
						console.log('this @ getEntry',this);
						var data = this;
						if(data[0].meta.krypi == "1"){
							var pwd = prompt("Please enter password to decrypt");
							if(pwd){
								var eContents = oblivious._processGetEntry(data,entry.entryid,pwd);
								oblivious_viewentry_data.contents = eContents;
								oblivious_viewentry_data.password = pwd;
							}else{
								
								$("#return-to-entries").click();
							}
					    }else{
					    	var eContents = oblivious._processGetEntry(data,entry.entryid,'');
					    	oblivious_viewentry_data.contents = eContents;
					    	console.log(oblivious_viewentry_data.contents);
					    }
						
						$.unblockUI();
					});
				} });
					
				return false;
			}
		});
	});
$('body').on('click','#loadblackbook-button',function(){
	console.log('loading blackbook...');

	
	var Entries =[];
	var localMeta = oblivious.blackbookGet('meta');
	$.each(localMeta,function(i,obj){
		var tmpEntry = {
				'category':'',
				'entryid':'',
				'meta':''
		};
		if(obj.value != ''){
			tmpEntry.entryid = obj.key;
			tmpEntry.category = obj.value.category;
			tmpEntry.meta = obj.value;
			Entries.push(tmpEntry);
		}
	});
	oblivious_data.entries = Entries;
	oblivious_data.subnav.active = 'Blackbook';
	oblivious_data.freshload = false;
	oblivious_data.showinvite = true;
	
	$('.listed-entry').removeClass('has-changed');
	$.each(oblivious_data.hasChanged,function(i,tmpObj){
		console.log('oblivious_data.hasChanged',oblivious_data.hasChanged);
		$("#"+tmpObj.entryid).parent('.'+tmpObj.category).parent('.listed-entry').addClass('has-changed');
		//where do I remove this???
	});
	oblivious_data.hasChanged = [];
})
$('body').on('click','#return-to-entries',function(){
	oblivious_viewentry_data.password = '';
	oblivious_viewentry_data.category = '';
	oblivious_viewentry_data.entries = [];
	oblivious_viewentry_data._entryid = '';
	oblivious_viewentry_data.entryid = '';
		
		$("#oblivious_entrylist").show();
		$("#oblivious_viewentry").hide();
	});
$('body').on('click','.invite-button',function(){
	//clear fields
	$("#invite-pwd").val('');
	var entryID = $(this).attr('eid');
	var cat = $(this).attr('ecat');
	oblivious_viewentry_data._entryid = entryID;
	oblivious_viewentry_data.category = cat;
	console.log('did this work?',cat);
});
$('body').on('click','.add-comment-button',function(){
	//clear fields
	$("#addcommentform")[0].reset();
});
$('body').on('click','#send-invite-button',function(){
	var entryid = oblivious_viewentry_data._entryid;
	var entrycategory = oblivious_viewentry_data.category;
	
	if($("#invite-pwd").val() != ''){
			oblivious._generateInvite(entryid,entrycategory);
			//clear fields
			$("#invite-pwd").val('');
	}
	
});
	var commentviewdata = {
			'newcomment':{
				'text':'',
				'img':'',
			}
	};
	oblivious._onchange('addimage-input',function(){
		var imgData = String(this);
		commentviewdata.newcomment.img = imgData;
	});
	
	$(document).on('click', '#send-comment-button', function () {
		console.log('commentviewdata',commentviewdata);
		console.log('oblivious_viewentry_data',oblivious_viewentry_data);
		commentviewdata.newcomment.text = $("#comment-text").val();
		if(commentviewdata.newcomment.text == "" && commentviewdata.newcomment.img == ""){
			console.log('no comment entered');
		}else{
			//oblivious.addEntryComment(entryID,category,comment,nickname)
			//oblivious_viewentry_data._entryid
			//oblivious_viewentry_data.category
			//commentviewdata.newcomment.text
			//commentviewdata.newcomment.img
			var d ={ comment:String(commentviewdata.newcomment.text),
		             imgdata:'',
		             userkey:'',
		             containsimage:0,
		             nickname:''
			     };
			if(commentviewdata.newcomment.img != ''){
				d.imgdata = commentviewdata.newcomment.img;
				d.containsimage = 1;
			}
			console.log('d',d);
			$.blockUI({ onBlock:function(){
				oblivious.addEntryComment(oblivious_viewentry_data._entryid, 
						oblivious_viewentry_data.category,
						d,function(){
					
							console.log('this@addentrycomment',String(this));
							oblivious.getEntry(oblivious_viewentry_data._entryid,oblivious_viewentry_data.category,function(){
								
								var data = this;
								if(data[0].meta.krypi == "1"){
									var pwd = prompt("Please enter password to decrypt");
									if(pwd){
										var eContents = oblivious._processGetEntry(data,oblivious_viewentry_data._entryid,pwd);
										oblivious_viewentry_data.contents = eContents;
									}else{
										
										$("#return-to-entries").click();
									}
							    }else{
							    	var eContents = oblivious._processGetEntry(data,oblivious_viewentry_data._entryid,'');
							    	oblivious_viewentry_data.contents = eContents;
							    	console.log(oblivious_viewentry_data.contents);
							    }
								
								$.unblockUI();
							});
						}
						);
			}});
				
			
		}
	});

	$(document).on('cancellation', '.remodal', function () {
	  console.log('Cancel button is clicked');
	});
	
	$(document).on('ready',function(){
		$("nav>ul>li").on("click",function(){
			$('#category-container>select').val('');
			$("#addentryform")[0].reset();
			
		});
	});
	
	//blackbook check
	var bbcheck = function(){
		var Entries =[];
		var localMeta = oblivious.blackbookGet('meta');
		var localCommCount = oblivious.blackbookGet('commentcount');
		$.each(localMeta,function(i,obj){
			var tmpEntry = {
					'category':'',
					'entryid':'',
					'commentcount':'',
			};
			console.log('tmpEntry',tmpEntry);
			tmpEntry.entryid = obj.key;
			tmpEntry.category = obj.value.category;
			console.log('tmpEntry',tmpEntry);
			$.each(localCommCount,function(j,cObj){
				console.log('cObj',cObj);
				
				if(cObj.key === obj.key + ":" + obj.value.category){
					tmpEntry.commentcount = cObj.value;
					return false;
				}
			});
			console.log('tmpEntry',tmpEntry);
			if(typeof tmpEntry.category != 'undefined' && typeof tmpEntry.entryid != 'undefined' && typeof tmpEntry.commentcount != 'undefined'){
				if(tmpEntry.category != '' && tmpEntry.entryid != '' && tmpEntry.commentcount != ''){
					console.log('tmpEntry',tmpEntry);
					Entries.push(tmpEntry);
				}
			}

				
		});
		if(Entries.length == 0)
			return false;
		console.log('Entries',Entries);
		$.post( "api/blackbook/", {blackbookdata:Entries})
		  .done(function( data ) {
		    oblivious_data.hasChanged = [];
		    	data = JSON.parse(data);
		    	var currEntries = [];
		    	var newCommentCount = {};
		    	
			    $.each(data,function(i,obj){
			    		//obj[0] is the entry
			    	if(obj.length == 0)
			    		return false;
			    	
			    		if(obj[0].changed){
			    			var tmp = {
			    					'entryid':obj[0].entryid,
			    					'category':obj[0].category
			    			};
			    			oblivious_data.hasChanged.push(tmp);
			    			console.log('change!',obj[0]);
			    			newCommentCount[obj[0].entryid + ":" + obj[0].category] = obj[0].commentcount;
				    		
			    		}
			    		currEntries.push(obj[0]);	
			    });
			    
			    //delete obsolete entries from BB
			    var localMeta = oblivious.blackbookGet('meta');
			    var newMeta = [];
				$.each(localMeta,function(i,obj){
					var stillExists = currEntries.filter( function(item){return (item.category==obj.value.category && item.entryid==obj.key);} );
					console.log(stillExists);
					if(stillExists.length == 0){
						oblivious.blackbookSet('commentcount',obj.key+":"+obj.value.category ,-1);
					}else{
						console.log('newComment',newCommentCount,typeof newCommentCount[obj.key+":"+obj.value.category]);
						if(typeof newCommentCount[obj.key+":"+obj.value.category] !== 'undefined'){
							
							oblivious.blackbookSet('commentcount',obj.key+":"+obj.value.category,newCommentCount[obj.key+":"+obj.value.category]);
						}else{
							
						}
					}
				});
				
				//if @ blackbook
				if(oblivious_data.subnav.active == 'Blackbook' && $("#oblivious_viewentry").css('display') === 'none'){
					$('#loadblackbook-button').click();
				}else if ($("#oblivious_viewentry").css('display') === 'block'){
					oblivious.getEntry(oblivious_viewentry_data._entryid,oblivious_viewentry_data.category,function(){
						console.log('this @ getEntry',this);
						var data = this;
						if(data[0].meta.krypi == "1"){
							var pwd = oblivious_viewentry_data.password;
							if(pwd){
								var eContents = oblivious._processGetEntry(data,oblivious_viewentry_data._entryid,pwd);
								oblivious_viewentry_data.contents = eContents;
								window.scrollTo(0,$('#oblivious_viewentry')[0].scrollHeight);
							}else{
								
								$("#return-to-entries").click();
							}
					    }else{
					    	var eContents = oblivious._processGetEntry(data,oblivious_viewentry_data._entryid,'');
					    	oblivious_viewentry_data.contents = eContents;
					    	window.scrollTo(0,$('#oblivious_viewentry')[0].scrollHeight - 100);
					    }
						
					});
				}
				
		  }, "json");
	};
	bbcheck();
	window.setInterval(bbcheck,30000); //check every 30s
});
