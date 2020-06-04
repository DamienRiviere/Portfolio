import '../css/app.css';
import '../css/admin.css';

const $ = require('jquery');

(function ($) {
    "use strict"; // Start of use strict

    // Toggle the side navigation
    $("#sidebarToggle").on("click", function (e) {
        e.preventDefault();
        $("body").toggleClass("sidebar-toggled");
        $(".sidebar").toggleClass("toggled");
    });

    // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
    $("body.fixed-nav .sidebar").on("mousewheel DOMMouseScroll wheel", function (e) {
        if ($(window).width() > 768) {
            var e0 = e.originalEvent,
                delta = e0.wheelDelta || -e0.detail;
            this.scrollTop += (delta < 0 ? 1 : -1) * 30;
            e.preventDefault();
        }
    });

    function scroll()
    {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', (e) => {
                e.preventDefault();

                document.querySelector(anchor.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    }

    function modalDelete()
    {
        $(document).on("click", ".delete-item", function () {
            let id = $(this).data("id");
            let name = $(this).data("name");

            $(".modal-delete-item").attr("data-id", +id);
            $(".modal-delete-item").attr("data-name", +name);
            $(".modal-title").append("Supprimer " + name);
            $(".modal-body").append("Êtes-vous sur de vouloir supprimer " + name + " ?");
        });

        let url = checkAdminUrl();

        $(document).on("click", ".modal-delete-item", function () {
            let id = $(this).data("id");
            let name = $(this).data("name");

            $(".modal-delete-item").attr("href", "/admin/" + url + "/delete/" + id);
        });
    }

    function checkAdminUrl()
    {
        if (window.location.pathname === "/admin/technology") {
            return "technology";
        }

        if (window.location.pathname === "/admin/project") {
            return "project";
        }
    }

    window.onload = (() => {
        scroll();
        modalDelete();
    });
})($); // End of use strict

