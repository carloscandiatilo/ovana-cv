<x-guest-layout>
    <div style="min-height: 100vh; display: flex; flex-direction: column; justify-content: center; align-items: center; background-color: #f9fafb; padding-top: 2rem; padding-bottom: 2rem;">
        <div style="width: 100%; max-width: 420px; margin-top: 1rem; padding: 2rem 2.5rem; background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.08); border-radius: 10px;">

            <!-- Logo -->
            <div style="display: flex; justify-content: center; margin-bottom: 1rem;">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" style="height: 40px; width: 40px;">
            </div>

            <h2 style="text-align: center; font-size: 1.5rem; font-weight: 700; color: #1f2937; margin-bottom: 1.5rem;">
                Crie sua conta
            </h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nome -->
                <div style="margin-bottom: 1rem;">
                    <label for="name" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">Nome completo *</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                        style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.95rem; color: #111827; outline: none;"
                        onfocus="this.style.borderColor='#4f46e5';" onblur="this.style.borderColor='#d1d5db';">
                    <x-input-error :messages="$errors->get('name')" class="mt-1 text-red-500 text-sm" />
                </div>

                <!-- Email -->
                <div style="margin-bottom: 1rem;">
                    <label for="email" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">E-mail *</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                        style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.95rem; color: #111827; outline: none;"
                        onfocus="this.style.borderColor='#4f46e5';" onblur="this.style.borderColor='#d1d5db';">
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-500 text-sm" />
                </div>

                <!-- Senha -->
                <div style="margin-bottom: 1rem;">
                    <label for="password" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">Senha *</label>
                    <input id="password" name="password" type="password" required
                        style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.95rem; color: #111827; outline: none;"
                        onfocus="this.style.borderColor='#4f46e5';" onblur="this.style.borderColor='#d1d5db';">
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-500 text-sm" />
                </div>

                <!-- Confirmar Senha -->
                <div style="margin-bottom: 1rem;">
                    <label for="password_confirmation" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">Confirmar Senha *</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                        style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.95rem; color: #111827; outline: none;"
                        onfocus="this.style.borderColor='#4f46e5';" onblur="this.style.borderColor='#d1d5db';">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-red-500 text-sm" />
                </div>

                <!-- Botões -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1.5rem;">
                    <a href="/admin" style="font-size: 0.875rem; color: #4b5563; text-decoration: none;" 
                       onmouseover="this.style.color='#4f46e5';" onmouseout="this.style.color='#4b5563';">
                        Já tem uma conta? Entrar
                    </a>
                    <button type="submit"
                        style="padding: 0.5rem 1.5rem; background-color: #374151; color: white; font-weight: 600; border: none; border-radius: 6px; cursor: pointer;"
                        onmouseover="this.style.backgroundColor='#111827';" onmouseout="this.style.backgroundColor='#374151';">
                        Registrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
