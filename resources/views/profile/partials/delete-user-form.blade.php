<section class="space-y-6">
    <header>
        <h2 class="font-display text-xl font-black text-rose-600 uppercase tracking-tight">
            Vùng <span class="text-ink-primary">nguy hiểm</span>
        </h2>

        <p class="mt-2 text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50 leading-relaxed">
            Hành động này sẽ xóa vĩnh viễn tài khoản và tất cả dữ liệu liên quan.
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="w-full rounded-2xl bg-rose-50 px-6 py-4 text-[10px] font-black uppercase tracking-widest text-rose-600 ring-1 ring-inset ring-rose-200 transition-all hover:bg-rose-600 hover:text-white hover:shadow-xl hover:shadow-rose-500/20 active:scale-[0.98]"
    >
        Xác nhận xóa tài khoản
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-10 bg-white">
            @csrf
            @method('delete')

            <div class="mb-8 flex h-16 w-16 items-center justify-center rounded-2xl bg-rose-50 text-rose-600">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
            </div>

            <h2 class="font-display text-3xl font-black text-ink-primary uppercase tracking-tighter">
                Xác nhận <span class="text-rose-600">xóa bỏ?</span>
            </h2>

            <p class="mt-3 text-xs font-medium leading-relaxed text-ink-secondary/60">
                Khi tài khoản bị xóa, mọi dữ liệu cư trú, hóa đơn và lịch sử báo hỏng của bạn sẽ biến mất vĩnh viễn. Vui lòng nhập mật khẩu để xác nhận.
            </p>

            <div class="mt-8 space-y-2 group">
                <label for="password" class="text-[10px] font-black uppercase tracking-[0.2em] text-ink-secondary/40 ml-1">Mật khẩu xác nhận</label>
                <div class="relative">
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="pdu-input pl-11 border-rose-100 focus:border-rose-500 focus:ring-rose-500/20"
                        placeholder="••••••••"
                    />
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-rose-300">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                </div>

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 ml-1" />
            </div>

            <div class="mt-10 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                <button type="button" x-on:click="$dispatch('close')" class="rounded-2xl px-8 py-4 text-[10px] font-black uppercase tracking-widest text-ink-secondary hover:bg-ui-bg transition-colors">
                    Hủy thao tác
                </button>

                <button type="submit" class="rounded-2xl bg-rose-600 px-8 py-4 text-[10px] font-black uppercase tracking-widest text-white shadow-xl shadow-rose-500/20 transition-all hover:bg-rose-700 active:scale-95">
                    Xác nhận xóa vĩnh viễn
                </button>
            </div>
        </form>
    </x-modal>
</section>
