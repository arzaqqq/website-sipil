<style>
    body {
    background-image: url("{{url('img/bg2.jpg')}}");
    background-repeat: no-repeat;
}


@media screen and (min-width: 1024px) {
    main {
        position: absolute; right: 100px;
    }

    main:before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: #83b453;
        border-radius: 12px;
        z-index: -9;

        /*box-shadow: -50px 80px 4px 10px #555;*/
        -webkit-transform: rotate(7deg);
        -moz-transform: rotate(7deg);
        -o-transform: rotate(7deg);
        -ms-transform: rotate(7deg);
        transform: rotate(7deg);
    }


}
</style>