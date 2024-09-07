<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3>Customer Comments</h3>

                    @if (empty($comments))
                        <p>No comments available.</p>
                    @else
                        <div class="carousel-container">
                            <div class="carousel">
                                @foreach ($comments as $index => $comment)
                                    <div class="card" data-index="{{ $index }}">
                                        <h3 class="title">
                                            {{ $comment[0] ?? 'Unknown Name' }} 
                                            (Product: {{ $comment[1] ?? 'Unknown Product' }})
                                        </h3>
                                        <p class="comment">{{ $comment[2] ?? 'No comment provided' }}</p>
                                    </div>
                                @endforeach
                            </div>
                            <button class="prev" onclick="prevSlide()">&#10094;</button>
                            <button class="next" onclick="nextSlide()">&#10095;</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        body {
            background-color: #100e17;
            font-family: 'Open Sans', sans-serif;
        }

        .carousel-container {
            position: relative;
            width: 200px;
            height: 300px;
            margin: auto;
            overflow: hidden;
            border-radius: 7px;
        }

        .carousel {
            display: flex;
            transition: transform 0.5s ease-in-out;
            width: 300px;
            height: 400px;
        }

        .card {
            min-width: 200px; /* Match the carousel width */
            height: 300px;    /* Match the carousel height */
            background-color: #17141d;
            padding: 20px;
            box-shadow: -1rem 0 3rem #000;
            color: white;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center; /* Center items horizontally */
            box-sizing: border-box;
        }

        .title {
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 50px; /* Adjust spacing between title and comment */
        }

        .comment {
            font-size: 14px;
            line-height: 1.5;
            overflow-wrap: break-word; /* Ensure long comments wrap onto the next line */
            text-align: left; /* Center comment text */
            margin: 0; /* Reset margins for consistent positioning */
            max-height: 200px; /* Optional: limit comment height to keep card consistent */
            display: flex;
            flex-direction: column;
            justify-content: center; /* Center comments vertically */
            margin-bottom: 100px;
        }

        .prev, .next {
            position: absolute;
            top: 50%;
            width: 30px;
            height: 30px;
            background-color: rgba(255, 255, 255, 0.5);
            border: none;
            border-radius: 50%;
            cursor: pointer;
            z-index: 1000;
            transform: translateY(-50%);
        }

        .prev {
            left: 10px;
        }

        .next {
            right: 10px;
        }

        .prev:hover, .next:hover {
            background-color: rgba(255, 255, 255, 0.8);
        }
    </style>

    <script>
        let currentIndex = 0;
        const cards = document.querySelectorAll('.card');
        const totalCards = cards.length;
        const carousel = document.querySelector('.carousel');
        
        function showSlide(index) {
            if (index >= totalCards) currentIndex = 0;
            else if (index < 0) currentIndex = totalCards - 1;
            else currentIndex = index;
            
            carousel.style.transform = `translateX(${-currentIndex * 200}px)`; /* Adjust to match card width */
        }
        
        function nextSlide() {
            showSlide(currentIndex + 1);
        }
        
        function prevSlide() {
            showSlide(currentIndex - 1);
        }
        
        function startAutoSlide() {
            setInterval(nextSlide, 5000);
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            startAutoSlide();
        });
    </script>
</x-app-layout>
