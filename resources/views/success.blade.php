<x-front-layout>
  <!-- Main Content -->
  <section class="bg-darkGrey relative py-[70px] min-h-[calc(100vh-70px)] lg:min-h-[calc(100vh-135px)]">
    <div class="overflow-hidden">
      <div class="flex items-center justify-center gap-5 lg:justify-between">
        <div class="flex flex-col items-center md:ml-48">
          <header class="mb-[30px] text-center">
            <h2 class="font-bold text-dark text-[26px] mb-1">
              Success Booking
            </h2>
            <p class="text-base text-secondary">We will email you the confirmation <br>
              and the next instructions</p>
          </header>
          <!-- Button Primary -->
          <div class="p-1 rounded-full bg-primary group w-[220px]">
            <a href="{{ route('front.index') }}" class="btn-primary">
              <p>
                My Dashboard
              </p>
              <img src="/svgs/ic-arrow-right.svg" alt="">
            </a>
          </div>
        </div>
        <img src="/images/porsche_small.webp" class="max-w-[50%] hidden lg:block -mr-[100px]" alt="">
      </div>
    </div>
  </section>
</x-front-layout>
