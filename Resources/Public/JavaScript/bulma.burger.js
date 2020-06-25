document.addEventListener('DOMContentLoaded', () => {

    // Get first "navbar-burger" element
    const $navbarBurger = document.querySelector('.navbar-burger');

    if ($navbarBurger) {
        const target = $navbarBurger.dataset.target;
        $currentTarget = document.getElementById(target);

        $navbarBurger.addEventListener('click', () => {
            // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
            $navbarBurger.classList.toggle('is-active');
            $currentTarget.classList.toggle('is-active');
        });

        window.addEventListener('click', function(e){
            if (!$currentTarget.contains(e.target) && (!$navbarBurger.contains(e.target))){
                $navbarBurger.classList.remove('is-active');
                $currentTarget.classList.remove('is-active');
            }
        });
    }
});
