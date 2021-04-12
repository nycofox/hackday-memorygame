<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Schibsted Memory Game</title>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-blue-200">
<!-- Memory Game -->
<div x-data="game()" class="px-10 flex items-center justify-center min-h-screen">
    <h1 class="fixed top-0 right-0 p-10 font-bold text-3xl">
        <span x-text="points"></span>
        <span class="text-xs">pts</span>
    </h1>

    <div class="flex-1 grid grid-cols-5 gap-10">
        <template x-for="(card, index) in cards" :key="index">
            <div>
                <button x-show="! card.cleared"
                        :style="'background-repeat: no-repeat; background-position: center; background-size: contain; background-image: url(' + (card.flipped ? '{{ url('img/logos') }}/' + card.image : '{{ url('/img/cardback.png') }})')"
                        :disabled="flippedCards.length >= 2"
                        class="w-40 h-40 bg-blue-100"
                        @click="flipCard(card)"
                >
                </button>
            </div>
        </template>
    </div>
</div>

<!-- Flash Message -->
<div x-data="{ show: false, message: '' }"
     x-show.transition.opacity="show"
     x-text="message"
     @flash.window="
            message = $event.detail.message;
            show = true;
            setTimeout(() => show = false, 1000)
        "
     class="fixed bottom-0 right-0 bg-green-500 text-white p-2 mb-4 mr-4 rounded"
>
</div>

<script>
    function pause(milliseconds = 1000) {
        return new Promise(resolve => setTimeout(resolve, milliseconds));
    }

    function flash(message) {
        window.dispatchEvent(new CustomEvent('flash', {
            detail: {message}
        }));
    }

    function game() {
        return {
            cards: [
                @foreach ($images as $image)
                    { image: '{{ $image }}', flipped: false, cleared: false },
                @endforeach
            ].sort(() => Math.random() - .5),

            get flippedCards() {
                return this.cards.filter(card => card.flipped);
            },

            get clearedCards() {
                return this.cards.filter(card => card.cleared);
            },

            get remainingCards() {
                return this.cards.filter(card => !card.cleared);
            },

            get points() {
                return this.clearedCards.length;
            },

            async flipCard(card) {
                card.flipped = !card.flipped;

                if (this.flippedCards.length !== 2) return;

                if (this.hasMatch()) {
                    flash('You found a match!');

                    await pause();

                    this.flippedCards.forEach(card => card.cleared = true);

                    if (!this.remainingCards.length) {
                        alert('You Won!');
                    }
                } else {
                    await pause();
                }

                this.flippedCards.forEach(card => card.flipped = false);
            },

            hasMatch() {
                return this.flippedCards[0]['image'] === this.flippedCards[1]['image'];
            }
        };
    }
</script>
</body>
</html>
