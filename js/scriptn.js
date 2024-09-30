$(document).ready(function () {
    // URL for the dynamic image
    const imageUrl = "https://dummyjson.com/image/400x200/282828?fontFamily=pacifico&text=I+am+a+pacifico+font";

    $.ajax({
        url: imageUrl,
        method: 'GET',
        xhrFields: {
            responseType: 'blob' 
        },
        success: function(response) {
            let imageUrl = URL.createObjectURL(response);

            let img = document.createElement('img');
            img.src = imageUrl;
            img.className = 'd-block w-100';
            img.alt = 'Dynamic Image';

            let newItem = document.createElement('div');
            newItem.className = 'carousel-item';
            newItem.appendChild(img);

            document.querySelector('.carousel-inner').appendChild(newItem);
        },
        error: function(err) {
            console.error("Error loading image", err);
        }
    });

    $('.filter-btn').on('click', function () {
        const category = $(this).data('category');
        
        if (category === 'all') {
            $('img').removeClass('hidden'); 
        } else {
            $('img').each(function () {
                const imgCategory = $(this).data('category');
                if (imgCategory !== category) {
                    $(this).addClass('hidden');
                } else {
                    $(this).removeClass('hidden');
                }
            });
        }
    });
});
