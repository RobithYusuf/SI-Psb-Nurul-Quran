<x-filament::page>
    <div class="grid grid-cols-4 gap-2">
        <div class="col-span-3"></div>
        <div x-data="countdown" class="flex justify-center text-2xl text-center space-x-2 border rounded-full py-1 px-3 border border-gray-300 bg-white dark:bg-gray-800">
            <div class="w-8" x-text="hours"></div>
            <div>:</div>
            <div class="w-8" x-text="minutes"></div>
            <div>:</div>
            <div class="w-8 text-left" x-text="seconds"></div>
        </div>
    </div>
    <form wire:submit.prevent="submit" class="space-y-6">
        {{ $this->form }}

        <x-filament::button type="submit">
            Kirim Jawaban
        </x-filament::button>
    </form>
    <script>
        function countdown() {
            return {
                timeRemaining: 0,
                hours() {
                    return Math.floor(this.timeRemaining / 3600).toString().padStart(2, '0');
                },
                minutes() {
                    return Math.floor((this.timeRemaining % 3600) / 60).toString().padStart(2, '0')
                },
                seconds() {
                    return (this.timeRemaining % 60).toString().padStart(2, '0')
                },

                init() {
                    const self = this;

                    const timer = setInterval(() => {
                        self.timeRemaining = Math.floor((new Date(self.$wire.shouldEndAt * 1000) - Date.now()) / 1000);
                        if (self.timeRemaining <= 0) {
                            clearInterval(timer);
                            alert('Waktu ujian telah habis');
                            self.$dispatch('submit');
                        }
                    }, 1000);
                },

            };
        }
    </script>
</x-filament::page>
