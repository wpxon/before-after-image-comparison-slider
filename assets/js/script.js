window.addEventListener('DOMContentLoaded', (event) => {

    
    // let layout = document.querySelector('.slider-preview').dataset.layout;

    // I hope this over-commenting helps. Let's do this!
    // Let's use the 'active' variable to let us know when we're using it
    let active = false;

    // First we'll have to set up our event listeners
    // We want to watch for clicks on our scroller
    document.querySelectorAll('.scroller').forEach(item => {
        item.addEventListener('mousedown',function(){
            active = true;
            // Add our scrolling class so the scroller has full opacity while active
            item.classList.add('scrolling');
        });
    });
    
    // We also want to watch the body for changes to the state,
    // like moving around and releasing the click
    // so let's set up our event listeners
    document.body.addEventListener('mouseup',function(){
        active = false;
        document.querySelectorAll('.scroller').forEach(item => { 
            item.classList.remove('scrolling'); 
        }); 
    });
    document.body.addEventListener('mouseleave',function(){
        active = false;
        document.querySelectorAll('.scroller').forEach(item => { 
            item.classList.remove('scrolling'); 
        });
    });

    // Let's use this function
    function scrollIt(x,id,layout){
        let after = '#'+id+' .after';
        let scroller = '#'+id+' .scroller';
        if( layout == 'horizontal' ){
            let transform = Math.max(0,(Math.min(x,document.getElementById(id).offsetWidth)));
            if( transform > 0 ) transform +=1;
            document.querySelector(after).style.width = transform+"px";
            document.querySelector(scroller).style.left = transform-25+"px";
        }
        if( layout == 'vertical' ){ 
            let y = x;
            let transform = Math.max(0,(Math.min(y,document.getElementById(id).offsetHeight)));
            if( transform > 0 ) transform +=1;
            document.querySelector(`#${id} .after`).style.height = transform+"px";
            document.querySelector(`#${id} .scroller`).style.top = transform-25+"px";
        }
    }
 
    document.querySelectorAll('.slider-preview').forEach(item => {
        let id = item.id;
        let layout = item.dataset.layout;
        let auto_mousemove = item.dataset.autoMousemove; 
        let default_offset,percentage;

        let img_offset = item.dataset.offset;  
        if( layout == 'horizontal' ){
            let wrapper_width = item.offsetWidth; 
            percentage = ( wrapper_width * img_offset ) / 100; 
            default_offset = percentage || ( wrapper_width /2 );
        } 
        if( layout == 'vertical' ){
            let wrapper_height = item.offsetHeight; 
            percentage = ( wrapper_height * img_offset ) / 100; 
            default_offset = percentage || ( wrapper_height /2 );
        }


        // Let's figure out where their mouse is at
        document.getElementById(id).addEventListener('mousemove',function(e){ 
            if(auto_mousemove != 'on'){
                if (!active) return;
            }
            // Their mouse is here...
            let x = e.clientX;
            let y = e.clientY;
            // but we want it relative to our wrapper
            if( layout == 'horizontal' ){
                x -= document.getElementById(id).getBoundingClientRect().left;
            }
            if( layout == 'vertical' ){ 
                y -= document.getElementById(id).getBoundingClientRect().top; 
                x = y;
            }
            // Okay let's change our state
            scrollIt(x,id,layout); 
        });
        scrollIt(default_offset,id,layout);
    }); 


    // Let's set our opening state based off the width, 
    // we want to show a bit of both images so the user can see what's going on
  
 
    // And finally let's repeat the process for touch events
    // first our middle scroller... 
    document.querySelectorAll('.scroller').forEach(item => {
        item.addEventListener('touchstart',function(){
            active = true;
            // Add our scrolling class so the scroller has full opacity while active
            item.classList.add('scrolling');
        });
    });
    document.body.addEventListener('touchend',function(){
        active = false;
        document.querySelectorAll('.scroller').forEach(item => { 
            item.classList.remove('scrolling'); 
        });  
    });
    document.body.addEventListener('touchcancel',function(){
        active = false;
        document.querySelectorAll('.scroller').forEach(item => { 
            item.classList.remove('scrolling'); 
        });  
    });
 
}); 