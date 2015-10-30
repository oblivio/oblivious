

        <div class="main-container oblivious-home remodal-bg">
            <div class="main wrapper clearfix">
			
			<div id="oblivious_entrylist" class="grd small">
		        <div class="grd-row my1">
		        	<div rv-if="oblivious_data.subnav.active">
		        		<h3>{oblivious_data.subnav.active}</h3>
		        		<hr />
		        	</div>
		        	<div id="instructions" rv-if="oblivious_data.freshload">
		        		<h3>Welcome to oblivious.</h3>
		        		<hr />
	     				<p><b>Public Feed</b>
	     					     					<img class="instructions-image floated-right" src="/code/oblivious/html/oblivious/flaticon/svg/feed3.svg">
	     				
	     					<br />
	     					The public feed let's you see all public posts.
	     				</p>
	     				<p><b>Blackbook</b>
	     					     					<img class="instructions-image floated-right" src="/code/oblivious/html/oblivious/flaticon/svg/visualization.svg">
	     				
	     					<br />
	     					The Blackbook keeps track of your oblivious entries.
	     				</p>
	     				<p><b>Add Entry</b>
	     					     					<img class="instructions-image floated-right" src="/code/oblivious/html/oblivious/flaticon/svg/add20.svg">
	     				
	     					<br />
							Create a new oblivious entry.
	     				</p>
	     				<p><b>Settings</b>
	     					     					<img class="instructions-image floated-right" src="/code/oblivious/html/oblivious/flaticon/svg/three115.svg">
	     				
	     					<br />
	     					Let's users configure their 'Blackbook'.
	     				</p>
		        	</div>
		        </div>
		        <div class="grd-row my1">
		          <div rv-each-entry="oblivious_data.entries" class="grd-row-col-1-4 listed-entry py1 my1 mx1 px1" >
		            <div rv-class="entry.category">
		            <div class="heading">
					        <span class="title">{entry.entryid}</span>
					</div>
					<div rv-id="entry.entryid" class="content oblivious-entry-button ">
	                    		<span  class="icon-holder">
	                    				<img rv-if="entry.meta.burnafterreading" src="<?php echo $path_from_index;?>flaticon/svg/fire14.svg" alt="oblivious entry">
	                    		
	                    				<img rv-if="entry.meta.containsimage" src="<?php echo $path_from_index;?>flaticon/svg/picture56.svg" alt="oblivious entry">
	                    				<img rv-if="entry.meta.opendiscussion" src="<?php echo $path_from_index;?>flaticon/svg/chat78.svg" alt="oblivious entry"> 
	                    				<img rv-if="entry.meta.encrypted" src="<?php echo $path_from_index;?>flaticon/svg/locked43.svg" alt="oblivious entry">
	                    				<img rv-if="entry.meta.krypi" src="<?php echo $path_from_index;?>flaticon/svg/login13.svg" alt="oblivious entry">			
										<img rv-if="entry.meta.unencrypted" src="<?php echo $path_from_index;?>flaticon/svg/open99.svg" alt="oblivious entry">					                	
	                    			</span>
									
					    </div>
					    <div id="entry-actions">
       	                    			<a rv-if="oblivious_data.showinvite" rv-eid="entry.entryid" rv-ecat="entry.category" href="#invitemodal" id="" class="invite-button btn btn--s floated-right full-width">Invite</a>
                    				 	<a rv-eid="entry.entryid" class="oblivious-entry-button btn btn--s btn--green floated-right full-width">View</a>
                    		
									</div>
					</div>
		          </div>
		        </div>
		      </div>
			
			
			
			
                
                <article style="display:none;" id="oblivious_viewentry">
                	<section>
                	
                	<a id="return-to-entries" class="category-btn btn btn--s full-width">Back to Entries</a>
                    <div class="oblivious-view-entry">
                    	<div rv-each-entry="oblivious_viewentry_data.entries"  class="">
                    		<h6 class="">{entry.category}:{entry.entryid}</h6>
                    		
                    		<hr />
                    		<a rv-eid="entry.entryid" href="#modal" rv-if="entry.meta.opendiscussion"  id="" class="oblivious-entry-button add-comment-button btn--blue btn--s">Add Comment</a>
				                	<a  rv-if="oblivious_data.showinvite" rv-eid="entry.entryid" rv-ecat="entry.category" href="#invitemodal" id="" class="invite-button btn btn--s  full-width">Invite</a>
				                	<span  class="icon-holder floated-right">
                    				<img rv-if="entry.meta.containsimage" src="<?php echo $path_from_index;?>flaticon/svg/picture56.svg" alt="oblivious entry">
                    				<img rv-if="entry.meta.burnafterreading" src="<?php echo $path_from_index;?>flaticon/svg/fire14.svg" alt="oblivious entry">
                    				
                    				<img rv-if="entry.meta.opendiscussion" src="<?php echo $path_from_index;?>flaticon/svg/chat78.svg" alt="oblivious entry"> 
                    				<img rv-if="entry.meta.encrypted" src="<?php echo $path_from_index;?>flaticon/svg/locked43.svg" alt="oblivious entry">
                    				<img rv-if="entry.meta.krypi" src="<?php echo $path_from_index;?>flaticon/svg/login13.svg" alt="oblivious entry">			
									<img rv-if="entry.meta.unencrypted" src="<?php echo $path_from_index;?>flaticon/svg/open99.svg" alt="oblivious entry">
									
									
                    		</span>
				                	<hr />
                    		<textarea id="view-entry-meta" class="view-entry-meta full-width" disabled="disabled" rows=10>
                    		
                    		</textarea>
                    	</div>
                    	<div class="processed-entry-contents">
                    		<div rv-each-econtent="oblivious_viewentry_data.contents" class="entry-content-container">
                    			<a  rv-if="econtent.image" rv-href="econtent.image" download="oblivious.png">
                    				<img rv-if="econtent.image" rv-src="econtent.image"  class="processed-entry-image" />
                    			</a>
                    			<hr />
                    			<p rv-if="econtent.text">{econtent.text}</p>
                    			<p rv-if="econtent.createdate">{econtent.createdate}</p>
                    			<p rv-if="econtent.expiretime">{econtent.expiretime}</p>
                    			<a  rv-if="econtent.identicon" rv-href="econtent.identicon" rv-download="entry.entryid">
                    				<img rv-if="econtent.identicon" rv-src="econtent.identicon"  class="processed-entry-identicon" />
                    			</a>
                    		</div>
                    	</div>
                    </div>
                    </section>
                </article>

               
                

            </div> <!-- #main -->
        </div> <!-- #main-container -->
        <div class="remodal" data-remodal-id="modal">
		  <button data-remodal-action="close" class="remodal-close"></button>
		  <div class="modal-content">
		  	<h3>Add Comment</h3>
						<hr />
					
					      <form id="addcommentform" action="#" role="form" class="my2">
					      	<img class="add-image-button" src="<?php echo $path_from_index;?>flaticon/svg/picture56.svg" alt="oblivious entry"> 
					      	<input id="addimage-input" type=file accept="image/*;capture=camera">				      	
					      	<hr /><label for="msg">Message</label>
					        <textarea 	rv-on-change="" id="comment-text" name="msg" rows="3" placeholder="New comment..."></textarea>
					        
					      </form>
		  </div>
		  <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
		  <button data-remodal-action="confirm" class="remodal-confirm" id="send-comment-button">Send</button>
		</div>
		<div class="remodal" data-remodal-id="invitemodal">
		  <button data-remodal-action="close" class="remodal-close"></button>
		  <div class="modal-content">
		  	<h3>Generate Invite</h3>
						<hr />
							<label for="invite-pwd">Password*:</label>
							<input id="invite-pwd" type="text" placeholder="(Required)" class="full-width" />
					      <input type="text" class="full-width" readonly="readonly" id="encodedinvite" placeholder="encodedinvite" />
					      <button id="send-invite-button" class="btn--green full-width">Generate Invite</button>
					      <hr />
					      <a id="invite-image" href="" download="invite.png"><img src="" /></a>
		  </div>
		  <button data-remodal-action="cancel" class="remodal-cancel full-width">Close</button>
		</div>
		<div id="subnav-home" class="remodal" data-remodal-id="loadmodal">
		  <button data-remodal-action="close" class="remodal-close"></button>
		  <div class="modal-content">
		  	<h3>Choose Category</h3>
						<hr />
			<div rv-if="oblivious_data.subnav.categories">
  						
                	    <div id="category-container">
                	    	<select  rv-on-change="oblivious_data.subnav.travel"	 id="current-category">
                	    		<option class="category-btn btn btn--s full-width">(choose a category)</option>
                	    		<option rv-each-category="oblivious_data.subnav.content" class="category-btn btn btn--s full-width">{category}</option>
                	    	</select>
                		</div>
                		<hr />
                		
                	</div>
		  </div>
		  <button data-remodal-action="cancel" class="remodal-cancel full-width">Close</button>
		</div>
		<div class="remodal" data-remodal-id="settings">
		  <button data-remodal-action="close" class="remodal-close"></button>
		  <div class="modal-content">
		  	<h3>Settings</h3>
			<hr />
			<article id="blackbook_management">
			 		<section class="measure p2">
			 			<h3>Blackbook</h3>
			 			<a id="clear-blackbook-button" data-cleartype="all" class="category-btn btn btn--red full-width">
               				Clear Blackbook
               			</a>
               			
			 		</section>
			 	</article>
		  </div>
		  <button data-remodal-action="cancel" class="remodal-cancel full-width">Close</button>
		</div>
		<div class="remodal" data-remodal-id="addmodal">
		  <button data-remodal-action="close" class="remodal-close"></button>
		  <div class="modal-content">
		  	<h3>Add Entry</h3>
						<hr />
						<article id="oblivious_addentry">
                <section class="" id="">
                <h5>Have an invite?</h5>
                <p style="display:none;" id="invite-status">Successfully processed invite! <a class="btn--red dismiss-button">dismiss</a></p>
                
                	<form id="inviteform" action="#" role="form" class="my2">
                		<label for="inviteinput">Enter Invite</label>
                		<input type="text" id="encodedinvite" class="full-width" />
                		<div id="invite-action">
                			
                		<input id="decode-input" class="" type=file accept="image/*;capture=camera">				      	
                		<input id="submit-invite-button" value="Submit Invite" class="btn--blue" type="button">
                		</div>
                	</form>
                <hr />	
                </section>
                 <section class="" id="">
					      <h5>Create Entry</h5>
						<hr />
					
					      <form id="addentryform" action="#" role="form" class="my2">
					      	<img class="add-image-button" src="<?php echo $path_from_index;?>flaticon/svg/picture56.svg" alt="oblivious entry"> 
					      	<input id="addimage-input" type=file accept="image/*;capture=camera">				      	
					      	<hr />
					        <label class="clientsidecrypto" for="crypto">Client-Side Crypto</label>
					        <input rv-on-change="viewdata.togglecrypto" class="clientsidecrypto" name="crypto" type="checkbox" />
					        
					        <label for="password">Password</label>
					        <input 	rv-on-change="viewdata.setAddProperty" id="entry-password" name="password" placeholder="Enter password" type="password">
					        <label for="msg">Message</label>
					        <textarea 	rv-on-change="viewdata.setAddProperty" id="entry-text" name="msg" rows="3" placeholder="Entry contents..."></textarea>
					        <label for="expiration">Expiration</label>
					        <select	rv-on-change="viewdata.setAddProperty" name="expiration" id="entry-expiration">
					        	<option value="never">Never</option>
					        	<option value="burnafter">Burn After Reading</option>
					        	<option value="5min">5 minutes</option>
					        	<option value="10min">10 minutes</option>
					        	<option value="1hour">1 hour</option>
					        	<option value="1day">1 day</option>
					        	<option value="1week">1 week</option>
					        	<option value="1month">1 month</option>
					        	<option value="1year">1 year</option>
					        </select>
					        <label for="metadata">Meta-Data</label>
					        <input id="metadata_entry" type="text" name="metadata" class="full-width" />
					        <textarea id="metadata_preview" disabled=true rows=3 placeholder="Entry MetaData JSON"></textarea>
					        <label for="category">
					        	Choose a Category
					        </label>
					        <select	rv-on-change="viewdata.setAddProperty" id="addentry-category">
                	    		<option class="category-btn btn btn--s full-width">(choose a category)</option>
                	    		<option rv-each-category="viewdata.categories" class="category-btn btn btn--s full-width">{category}</option>
                	    	</select>
                	    	<hr />
					      </form>
					    </section>   
                </article>
               
		  </div>
		  <button id="submit-entry-button" data-remodal-action="confirm" class="remodal-confirm full-width">Submit</button>
		  <button data-remodal-action="cancel" class="remodal-cancel full-width">Close</button>
		</div>
