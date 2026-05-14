@extends('theme')
@section('content')

    <!-- Page Header -->
    <div class="bg-success text-white py-4 py-md-5">
        <div class="container text-center">
            <h1 class="fw-bold mb-2 display-5">Наши услуги</h1>
            <p class="mb-0 opacity-75">Сделайте ваш отдых ещё более комфортным</p>
        </div>
    </div>

    <!-- Services Section -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                @forelse($services as $service)
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-3 bg-white service-card">

                            {{-- Фото услуги --}}
                            @if($service->photo)
                                <img src="{{ asset('storage/' . $service->photo) }}"
                                     class="rounded-3 mb-3"
                                     style="width: 100%; height: 150px; object-fit: cover;"
                                     alt="{{ $service->name }}">
                            @else
                                <div class="service-icon mb-3 text-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M4.5 3.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1zM2 6a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-11A.5.5 0 0 1 2 8V6zM5 11a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-2z"/>
                                    </svg>
                                </div>
                            @endif

                            {{-- Название --}}
                            <h5 class="fw-semibold mb-2">{{ $service->name }}</h5>

                            {{-- Описание --}}
                            @if($service->description)
                                <p class="text-muted small mb-3">{{ Str::limit($service->description, 60) }}</p>
                            @endif

                            {{-- Цена --}}
                            <p class="text-success fw-bold fs-5 mb-3">
                                {{ number_format($service->price, 0, '.', ' ') }} ₽
                            </p>

                            {{-- Кнопка заказа --}}
                            @auth
                                <a href="#" class="btn btn-sm btn-outline-success rounded-pill"
                                   data-bs-toggle="modal"
                                   data-bs-target="#serviceOrderModal"
                                   data-service-id="{{ $service->id }}"
                                   data-service-name="{{ $service->name }}"
                                   data-service-price="{{ $service->price }}">
                                    Заказать
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-success rounded-pill">
                                    Войти для заказа
                                </a>
                            @endauth
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="text-muted mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M4.5 3.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1zM2 6a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-11A.5.5 0 0 1 2 8V6zM5 11a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-2z"/>
                            </svg>
                        </div>
                        <h3 class="fw-bold mb-2">Услуги временно недоступны</h3>
                        <p class="text-muted">Попробуйте позже или свяжитесь с нами</p>
                        <a href="/contacts" class="btn btn-success rounded-pill px-4">
                            Контакты
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Modal для заказа услуги --}}
    @auth
        <div class="modal fade" id="serviceOrderModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold">Заказ услуги</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted mb-3">
                            Вы заказываете: <strong id="modalServiceName"></strong><br>
                            Цена: <span id="modalServicePrice" class="text-success fw-bold"></span>
                        </p>
                        <form action="{{ route('services.order') }}" method="POST">
                            @csrf
                            <input type="hidden" name="service_id" id="modalServiceId">

                            <div class="mb-3">
                                <label class="form-label small text-muted">Дата</label>
                                <input type="date" class="form-control" name="date" required min="{{ date('Y-m-d') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small text-muted">Время</label>
                                <select class="form-select" name="time" required>
                                    <option value="">Выберите время</option>
                                    <option value="10:00">10:00</option>
                                    <option value="12:00">12:00</option>
                                    <option value="14:00">14:00</option>
                                    <option value="16:00">16:00</option>
                                    <option value="18:00">18:00</option>
                                    <option value="20:00">20:00</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small text-muted">Комментарий</label>
                                <textarea class="form-control" name="comment" rows="2" placeholder="Дополнительная информация"></textarea>
                            </div>

                            <button type="submit" class="btn btn-success w-100 rounded-pill">Подтвердить заказ</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.getElementById('serviceOrderModal').addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                document.getElementById('modalServiceId').value = button.getAttribute('data-service-id');
                document.getElementById('modalServiceName').textContent = button.getAttribute('data-service-name');
                document.getElementById('modalServicePrice').textContent =
                    new Intl.NumberFormat('ru-RU').format(button.getAttribute('data-service-price')) + ' ₽';
            });
        </script>
    @endauth

    <style>
        .service-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            cursor: default;
        }
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15) !important;
        }
        .service-icon svg {
            transition: transform 0.2s ease;
        }
        .service-card:hover .service-icon svg {
            transform: scale(1.1);
        }
    </style>

@endsection
