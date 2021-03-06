
jQuery(document).ready(function($) {
    // tab script
    let tab_menu_wrapper = document.querySelector('.wpx-tab-menu');
    if (typeof(tab_menu_wrapper) != 'undefined' && tab_menu_wrapper != null){
        let tab_menus = tab_menu_wrapper.querySelectorAll('a');

        // active first tab item by default
        tab_menus.forEach( (item, i) => {
            if( i == 0 ){
                item.classList.add('active');
                let id = item.getAttribute('href');
                document.getElementById(id).classList.add('show');
            }
        });

        // changing tab content on click
        tab_menus.forEach( menu => {
            menu.onclick = e => {
                e.preventDefault();  
                // deactive all tabs
                tab_menus.forEach( item => {
                    item.classList.remove('active');
                    let id = item.getAttribute('href');
                    document.getElementById(id).classList.remove('show');
                });

                // active current tab
                e.target.classList.add('active');
                let id = e.target.getAttribute('href');
                document.getElementById(id).classList.add('show');
            };
        });
    }

    // shortcode copy script
    let shortcode = document.querySelector('.shortcode-display');
    if (typeof(shortcode) != 'undefined' && shortcode != null){
        let shortcode_display = document.querySelectorAll('.shortcode-display');
        shortcode_display.forEach(item => { 
            item.onclick = (e) => {
                e.preventDefault(); 
                e.target.select();
                document.execCommand("copy");
                let copy_notice = item.nextElementSibling; 
                copy_notice.classList.remove('hide');
                setTimeout(()=>{
                    copy_notice.classList.add('hide');
                },1500); 
            }
        });
    }
 
    //color picker
    $('.wpx-colorpicker').wpColorPicker();
    
    // clear image
    $('.img-remove').on('click', function (event) {
        var self = $(this);
        self.parent('.img-wrap').siblings('.wpx-img-field').val('');
        self.siblings('.image-preview ').addClass('hide'); 
    });

    // media uploader
    $('.wpx-browse').on('click', function (event) {
        event.preventDefault();

        var self = $(this);

        var file_frame = wp.media.frames.file_frame = wp.media({
            title: self.data('title'),
            button: {
                text: self.data('select-text'),
            },
            multiple: false
        });
 
        // if you have IDs of previously selected files you can set them checked
        file_frame.on('open', function() {
            let selected = self.prev('.wpx-img-field').val(); 
            let selected_values = selected.split(',');
            let image_id = selected_values[0];

            let selection = file_frame.state().get('selection');
            let ids = [image_id]; // array of IDs of previously selected files. You're gonna build it dynamically
            ids.forEach(function(id) {
                let attachment = wp.media.attachment(id);
                selection.add(attachment ? [attachment] : []);
            }); // would be probably a good idea to check if it is indeed a non-empty array
        });

        file_frame.on('select', function () {
            attachment = file_frame.state().get('selection').first().toJSON();
            self.prev('.wpx-img-field').val(attachment.id + ',' +attachment.url); 
            self.siblings('.img-wrap').find('.image-preview').attr('src',attachment.url).removeClass('hide'); 
            $('.supports-drag-drop').hide();
        });

        file_frame.on('close',function() { 
            $('.supports-drag-drop').hide();
        });

        file_frame.open();
    });

    // radio required script
    $('input[type=radio]').change(function() {
        let required_class = this.name;
        let value = this.value;

        $('.wpx-metabox-body tr').each(function(e){ 
            if( $(this).hasClass(required_class) ){
                if( value == 'off' ){
                    $(this).addClass('hide');
                }else{
                    $(this).removeClass('hide');
                }
            }
        }); 
    });
    $('input[type=radio]').each(function(e){ 
        let required_class = this.name;
        let value = this.checked;  
        $('.wpx-metabox-body tr').each(function(e){  
            if( $(this).hasClass(required_class) ){ 
                if( value ){
                    $(this).addClass('hide');
                }else{
                    $(this).removeClass('hide');
                }
            }
        }); 
    }); 
});