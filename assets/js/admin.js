window.onload = (e) => {

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


}