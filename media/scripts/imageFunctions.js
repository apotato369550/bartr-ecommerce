function readURL(input){
    if(input.files && input.files[0]){

        $(".default-indicator").remove();
        $(".default-slide").remove();

        var slides = $(".carousel-inner").html("");
        var indicators = $(".carousel-indicators").html("");

        for(var i = 0; i < input.files.length; i++){
            var reader = new FileReader();
            reader.onload = function(e){
                var images = slides.children().length;
                slides.append(`
                    <div class="carousel-item default-slide ${images ? "" : "active"}">
                        <img src="${e.target.result}" style="max-width: 1000px; height: auto;">
                    </div>
                `);
                indicators.append(`
                    <li data-target="#carousel" data-slide-to="${images}" class="${images ? '' : 'active'}"></li>
                `);
            }
            reader.readAsDataURL(input.files[i]);
        }
    }
}
