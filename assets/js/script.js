window.addEventListener('DOMContentLoaded', (event) => {

    // I hope this over-commenting helps. Let's do this!
    // Let's use the 'active' variable to let us know when we're using it
    let active = false;

    // First we'll have to set up our event listeners
    // We want to watch for clicks on our scroller
    document.querySelector('.scroller').addEventListener('mousedown',function(){
        active = true;
        // Add our scrolling class so the scroller has full opacity while active
        document.querySelector('.scroller').classList.add('scrolling');
    });

    // We also want to watch the body for changes to the state,
    // like moving around and releasing the click
    // so let's set up our event listeners
    document.body.addEventListener('mouseup',function(){
        active = false;
        document.querySelector('.scroller').classList.remove('scrolling');
    });
    document.body.addEventListener('mouseleave',function(){
        active = false;
        document.querySelector('.scroller').classList.remove('scrolling');
    });

    // Let's figure out where their mouse is at
    document.body.addEventListener('mousemove',function(e){ 
        if (!active) return;
        // Their mouse is here...
        let x = e.clientX;
        let y = e.clientY;
        // but we want it relative to our wrapper
        x -= document.querySelector('.slider-preview').getBoundingClientRect().left;
        y -= document.querySelector('.slider-preview').getBoundingClientRect().top; 
        // Okay let's change our state
        scrollIt(y);
    });

    // Let's use this function
    function scrollIt(x){
        let type = 'y';

        if( type == 'x' ){
            let transform = Math.max(0,(Math.min(x,document.querySelector('.slider-preview').offsetWidth)));
            document.querySelector('.after').style.width = transform+"px";
            document.querySelector('.scroller').style.left = transform-25+"px";
        }
        if( type == 'y' ){ 
            let transform = Math.max(0,(Math.min(x,document.querySelector('.slider-preview').offsetHeight)));
            document.querySelector('.after').style.height = transform+"px";
            document.querySelector('.scroller').style.top = transform-25+"px";
        }
    }

    // Let's set our opening state based off the width, 
    // we want to show a bit of both images so the user can see what's going on
    scrollIt(260);
 
    // And finally let's repeat the process for touch events
    // first our middle scroller...
    document.querySelector('.scroller').addEventListener('touchstart',function(){
        active = true;
        document.querySelector('.scroller').classList.add('scrolling');
    });
    document.body.addEventListener('touchend',function(){
        active = false;
        document.querySelector('.scroller').classList.remove('scrolling');
    });
    document.body.addEventListener('touchcancel',function(){
        active = false;
        document.querySelector('.scroller').classList.remove('scrolling');
    });
 
}); 