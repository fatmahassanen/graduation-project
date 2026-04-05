<div class="container-xxl py-5">
    <div class="container">
        @if($title)
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h2 class="mb-5">{{ $title }}</h2>
            </div>
        @endif

        <div class="row g-5">
            @if($image)
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="img-fluid position-absolute w-100 h-100" 
                             loading="lazy"
                             src="{{ $image }}" 
                             alt="FAQ" 
                             style="object-fit: cover;"
                             loading="lazy">
                    </div>
                </div>
            @endif

            <div class="{{ $image ? 'col-lg-6' : 'col-12' }} faq-section">
                <div class="faq">
                    @foreach($items as $index => $item)
                        <div>
                            <div class="faq-item" onclick="toggleAnswer(this)">
                                <span>{{ $item['question'] }}</span>
                            </div>
                            <div class="answer">
                                {{ $item['answer'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleAnswer(element) {
    const answer = element.nextElementSibling;
    if (answer.style.display === "block") {
        answer.style.display = "none";
        answer.classList.remove("show");
    } else {
        // Close all other answers
        document.querySelectorAll('.answer').forEach(ans => {
            ans.style.display = "none";
            ans.classList.remove("show");
        });
        // Open clicked answer
        answer.style.display = "block";
        answer.classList.add("show");
    }
}
</script>
