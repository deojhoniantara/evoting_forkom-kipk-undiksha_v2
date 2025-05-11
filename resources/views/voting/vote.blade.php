<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Halaman Voting</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4576D3',
                        accent: '#4DCEC6',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 via-cyan-50 to-primary font-sans">
    <div class="container mx-auto px-4 py-8 flex flex-col items-center" id="mainContent">
        <!-- Title Section -->
        <div class="text-center mb-4 px-4">
            @php
                $lines = explode("\n", $agenda->name); // Pisahkan teks berdasarkan baris
            @endphp

            @foreach ($lines as $index => $line)
                @if ($index === 0)
                    <h2 class="text-2xl sm:text-3xl font-bold text-primary mb-1">{{ $line }}</h2>
                @elseif ($index === 1)
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-700 mb-1">{{ $line }}</h3>
                @else
                    <h4 class="text-lg sm:text-xl font-bold text-gray-500">{{ $line }}</h4>
                @endif
            @endforeach
        </div>

        <!-- Main Card -->
        <div class="w-full max-w-7xl mx-auto px-4 py-4">
            <div class="relative bg-white/60 backdrop-blur-md rounded-2xl p-4 sm:p-6 md:p-8 flex flex-col items-center shadow-2xl overflow-visible">

                <!-- Card Body -->
                <div class="w-full">                    
                    <form action="{{ route('submit.vote', $voter->id) }}" method="POST" id="voteForm">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                            @foreach($candidates as $candidate)
                            <div class="group my-6">
                                <div class="bg-white rounded-xl shadow-md overflow-visible transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl border-2 border-transparent group-hover:border-accent h-full flex flex-col">
                                    <!-- Candidate Info -->
                                    <div class="p-4 sm:p-6 flex-grow">
                                        <div class="relative flex justify-center -mt-16 sm:mt-0 z-10">
                                        <div class="w-32 h-32 sm:w-40 sm:h-40 md:w-56 md:h-56 rounded-full p-1 shadow-2xl transition-all duration-500 group-hover:scale-110 group-hover:-translate-y-2 bg-white mx-auto">
                                        <div class="w-full h-full rounded-full overflow-hidden bg-white flex items-center justify-center">
                                                <img src="{{ $candidate->photo ? asset('storage/images/' . $candidate->photo) : asset('storage/images/default-avatar.png') }}" 
                                                    alt="{{ $candidate->name }}" 
                                                    class="object-contain w-full h-full transition-transform duration-500 group-hover:scale-105 group-hover:-rotate-2"
                                                    onerror="this.onerror=null; this.src='{{ asset('storage/images/default-avatar.png') }}';">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-4 text-center">
                                            <span class="inline-block bg-gradient-to-r from-primary to-accent text-white text-xs font-bold px-3 py-1 rounded-full mb-2 shadow transition-all duration-300 group-hover:bg-accent group-hover:text-primary">Kandidat {{ $loop->iteration }}</span>
                                            <div class="text-xl sm:text-2xl font-extrabold text-primary tracking-wide text-center drop-shadow mb-2">{{ $candidate->name }}</div>
                                        </div>
                                        
                                        <div class="space-y-3 sm:space-y-4">
                                            <div class="text-lg sm:text-xl font-bold text-primary mb-1 sm:mb-2 tracking-wide">Visi</div>
                                            <div class="text-sm sm:text-base text-gray-600 text-center font-bold leading-relaxed">{{ $candidate->vision }}</div>
                                            
                                            <div class="text-lg sm:text-xl font-bold text-primary mb-2 sm:mb-4 tracking-wide">Misi</div>
                                            <div class="flex flex-col gap-2 sm:gap-4 w-full">
                                                @php
                                                    $missions = is_array($candidate->mission) ? $candidate->mission : explode("\n", $candidate->mission);
                                                @endphp
                                                @foreach($missions as $idx => $misi)
                                                <div class="flex items-start gap-2 sm:gap-3">
                                                    <div class="flex-shrink-0 w-7 h-7 sm:w-9 sm:h-9 rounded-xl bg-primary/10 flex items-center justify-center font-bold text-primary text-sm sm:text-lg shadow-sm">{{ $idx+1 }}</div>
                                                    <div class="text-sm sm:text-base text-gray-700 leading-relaxed flex-1">{{ $misi }}</div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Vote Button -->
                                    <div class="p-4 sm:p-6">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="button" 
                                                class="w-full bg-primary hover:bg-accent text-white font-semibold py-2 sm:py-3 px-4 rounded-xl shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 vote-button"
                                                data-candidate-id="{{ $candidate->id }}">
                                            Vote
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Thank You Modal -->
    <div id="thankYouModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-2xl p-6 sm:p-8 max-w-md w-full mx-4 transform transition-all duration-500 scale-0 opacity-0">
            <!-- Checkmark Animation -->
            <div class="flex justify-center mb-4 sm:mb-6">
                <svg class="w-20 h-20 sm:w-24 sm:h-24 text-accent" viewBox="0 0 52 52">
                    <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none" stroke="currentColor" stroke-width="2"/>
                    <path class="checkmark__check" fill="none" stroke="currentColor" stroke-width="2" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                </svg>
            </div>

            <!-- Message -->
            <div class="text-center">
                <h3 class="text-xl sm:text-2xl font-bold text-primary mb-3 sm:mb-4">Terima Kasih!</h3>
                <p class="text-sm sm:text-base text-gray-600 leading-relaxed">
                    Suara Anda telah berhasil direkam.<br>
                    Terima kasih telah berpartisipasi dalam pemilihan ini.
                </p>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.vote-button').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove selected class from all cards
                document.querySelectorAll('.group').forEach(card => {
                    card.classList.remove('selected');
                });
                
                // Add selected class to clicked card
                this.closest('.group').classList.add('selected');

                const candidateId = this.dataset.candidateId;
                const form = document.getElementById('voteForm');
                
                // Disable all buttons
                document.querySelectorAll('.vote-button').forEach(btn => {
                    btn.disabled = true;
                });

                const formData = new FormData();
                formData.append('_token', document.querySelector('input[name="_token"]').value);
                formData.append('candidate_id', candidateId);

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Add blur effect to main content
                        document.getElementById('mainContent').style.filter = 'blur(5px)';
                        
                        // Show modal with animation
                        const modal = document.getElementById('thankYouModal');
                        modal.classList.remove('hidden');
                        setTimeout(() => {
                            modal.querySelector('.bg-white').classList.remove('scale-0', 'opacity-0');
                        }, 100);
                        
                        // Redirect after delay
                        setTimeout(() => {
                            window.location.href = "{{ route('voting.form') }}";
                        }, 3000);
                    } else {
                        alert(data.message);
                        document.querySelectorAll('.vote-button').forEach(btn => {
                            btn.disabled = false;
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                    document.querySelectorAll('.vote-button').forEach(btn => {
                        btn.disabled = false;
                    });
                });
            });
        });
    </script>
</body>
</html>
