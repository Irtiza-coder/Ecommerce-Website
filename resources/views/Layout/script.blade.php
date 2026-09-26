<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="{{ asset('js/carousel.js') }}"></script>

    <script>
        //   let img = "images/shop2.png";
        //   $(".btn", ".btn1").click((e) => {
        //     e.preventDefault();
        //     $(".imgchange").find("img").attr("src", img);
        //   });

        let img = "images/related2.png";

        $(".btn").click(function () {
        $(this).closest(".collection_card").find("img").attr("src", img);
        });
    </script>