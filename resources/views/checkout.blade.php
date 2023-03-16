<x-front-layout>
  <!-- Main Content -->
  <section class="bg-darkGrey relative py-[70px]">
    <div class="container">
      <header class="mb-[30px]">
        <h2 class="font-bold text-dark text-[26px] mb-1">
          Checkout & Drive Faster
        </h2>
        <p class="text-base text-secondary">We will help you get ready today</p>
      </header>

      <div class="flex items-center gap-5 lg:justify-between">
        <!-- Form Card -->
        <form action="{{ route('front.checkout.store', $item->slug) }}"
              class="bg-white p-[30px] pb-10 rounded-3xl max-w-[490px] w-full" x-data="app" method="POST"
              id="checkoutForm" x-cloak>
          @csrf
          @method('post')
          <div class="grid grid-cols-2 items-center gap-y-6 gap-x-4 lg:gap-x-[30px]">
            <!-- Full Name -->
            <div class="flex flex-col col-span-2 gap-3">
              <label for="" class="text-base font-semibold text-dark">
                Full Name
              </label>
              <input type="text" name="name" id="fullname" required
                     class="text-base font-medium focus:border-primary focus:outline-none placeholder:text-secondary placeholder:font-normal px-[26px] py-4 border border-grey rounded-[50px]"
                     placeholder="Insert Full Name" value="{{ Auth::user()->name }}">
            </div>

            <!-- RESULT DATES FROM-UNTIL -->
            <div class="col-span-2 grid-cols-2 gap-y-6 gap-x-4 lg:gap-x-[30px] hidden">
              <!-- Result Date From [HIDDEN] -->
              <div class="flex flex-col col-span-1 gap-3">
                <label for="" class="text-base font-semibold text-dark">
                  From (result)
                </label>
                <input type="text" name="start_date" id="dateFrom" required
                       class="text-base font-medium focus:border-primary focus:outline-none placeholder:text-secondary placeholder:font-normal px-[26px] py-4 border border-grey rounded-[50px] focus:before:appearance-none focus:before:!content-none"
                       placeholder="Select Date" readonly x-model="dateFromYmd">
              </div>
              <!-- Result Date Until [HIDDEN] -->
              <div class="flex flex-col col-span-1 gap-3">
                <label for="" class="text-base font-semibold text-dark">
                  Until (result)
                </label>
                <input type="text" name="end_date" id="dateUntil" required
                       class="text-base font-medium focus:border-primary focus:outline-none placeholder:text-secondary placeholder:font-normal px-[26px] py-4 border border-grey rounded-[50px] focus:before:appearance-none focus:before:!content-none"
                       placeholder="Select Date" readonly x-model="dateToYmd">
              </div>
            </div>

            <!-- START: INPUT DATE -->
            <div class="col-span-2 grid grid-cols-2 gap-y-6 gap-x-4 lg:gap-x-[30px] relative"
                 @keydown.escape="closeDatepicker()" @click.outside="closeDatepicker()">
              <!-- Date From -->
              <div class="flex flex-col col-span-1 gap-3">
                <label for="" class="text-base font-semibold text-dark">
                  From
                </label>
                <input readonly type="text"
                       class="text-base font-medium focus:border-primary focus:outline-none placeholder:text-secondary placeholder:font-normal px-[26px] py-4 border border-grey rounded-[50px] focus:before:appearance-none focus:before:!content-none"
                       placeholder="Select Date" @click="endToShow = 'from'; init(); showDatepicker = true"
                       x-model="outputDateFromValue">
              </div>
              <!-- Date Until -->
              <div class="flex flex-col col-span-1 gap-3">
                <label for="" class="text-base font-semibold text-dark">
                  Until
                </label>
                <input readonly type="text"
                       class="text-base font-medium focus:border-primary focus:outline-none placeholder:text-secondary placeholder:font-normal px-[26px] py-4 border border-grey rounded-[50px] focus:before:appearance-none focus:before:!content-none"
                       placeholder="Select Date" @click="endToShow = 'to'; init(); showDatepicker = true"
                       x-model="outputDateToValue">
              </div>

              <!-- START: Date-Range Picker -->
              <div class="absolute p-5 mt-2 bg-white rounded-[18px] top-full border border-grey w-full z-50 shadow-[0_22px_50px_0_rgba(212,214,218,0.25)]"
                   x-show="showDatepicker" x-transition>
                <div class="flex flex-col items-center">

                  <div class="w-full mb-5">
                    <div class="flex items-center justify-center gap-1">
                      <button type="button"
                              class="inline-flex p-1 mr-2 transition duration-100 ease-in-out rounded-full cursor-pointer hover:bg-gray-200"
                              @click="if (month == 0) {year--; month=11;} else {month--;} getNoOfDays()">
                        <svg class="inline-flex w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                      </button>
                      <span x-text="MONTH_NAMES[month]" class="text-base font-semibold text-dark"></span>
                      <span x-text="year" class="text-base font-semibold text-dark"></span>
                      <button type="button"
                              class="inline-flex p-1 ml-2 transition duration-100 ease-in-out rounded-full cursor-pointer hover:bg-gray-200"
                              @click="if (month == 11) {year++; month=0;} else {month++;}; getNoOfDays()">
                        <svg class="inline-flex w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                      </button>
                    </div>
                  </div>

                  <div class="flex flex-wrap w-full mb-3 -mx-1">
                    <template x-for="(day, index) in DAYS" :key="index">
                      <div style="width: 14.26%" class="px-1">
                        <div x-text="day" class="text-sm font-medium text-center text-dark">
                        </div>
                      </div>
                    </template>
                  </div>

                  <div class="flex flex-wrap -mx-1">
                    <template x-for="blankday in blankdays">
                      <div style="width: 14.28%" class="p-1 text-sm text-center border border-transparent">
                      </div>
                    </template>
                    <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">
                      <div style="width: 14.28%">
                        <div @click="getDateValue(date, false)" @mouseover="getDateValue(date, true)" x-text="date"
                             class="p-1 text-sm leading-loose text-center transition duration-100 ease-in-out cursor-pointer"
                             :class="{
                                 'font-bold': isToday(date) == true,
                                 'bg-primary text-white rounded-l-full': isDateFrom(
                                     date) == true,
                                 'bg-primary text-white rounded-r-full': isDateTo(date) ==
                                     true,
                                 'bg-[#E2E1FF]': isInRange(date) == true
                             }">
                        </div>
                      </div>
                    </template>
                  </div>
                </div>
              </div>
              <!-- END: Date-Range Picker -->
            </div>
            <!-- END: INPUT DATE -->

            <!-- Delivery Address -->
            <div class="flex flex-col col-span-2 gap-3">
              <label for="" class="text-base font-semibold text-dark">
                Delivery Address
              </label>
              <input type="text" name="address" id="address" required
                     class="text-base font-medium focus:border-primary focus:outline-none placeholder:text-secondary placeholder:font-normal px-[26px] py-4 border border-grey rounded-[50px]"
                     placeholder="Where should we deliver your car?">
            </div>

            <!-- City -->
            <div class="flex flex-col col-span-1 gap-3">
              <label for="" class="text-base font-semibold text-dark">
                City
              </label>
              <input type="text" name="city" id="city" required
                     class="text-base font-medium focus:border-primary focus:outline-none placeholder:text-secondary placeholder:font-normal px-[26px] py-4 border border-grey rounded-[50px] focus:before:appearance-none focus:before:!content-none"
                     placeholder="City Name">
            </div>

            <!-- Post Code -->
            <div class="flex flex-col col-span-1 gap-3">
              <label for="" class="text-base font-semibold text-dark">
                Write Code
              </label>
              <input type="number" name="zip" id="postCode" required
                     class="text-base font-medium focus:border-primary focus:outline-none placeholder:text-secondary placeholder:font-normal px-[26px] py-4 border border-grey rounded-[50px] focus:before:appearance-none focus:before:!content-none"
                     placeholder="Write code">
            </div>

            <!-- CTA Button -->
            <div class="col-span-2 mt-[26px]">
              <!-- Button Primary -->
              <div class="p-1 rounded-full bg-primary group">
                <a href="#!" class="btn-primary" id="checkoutButton">
                  <p>
                    Continue
                  </p>
                  <img src="/svgs/ic-arrow-right.svg" alt="">
                </a>
              </div>
            </div>
          </div>
        </form>

        <img src="/images/porsche_small.webp" class="max-w-[50%] hidden lg:block -mr-[200px]" alt="">
      </div>
    </div>
  </section>

  <script src="/js/dateRangePicker.js"></script>
  <script>
    // on checkoutButton click, submit the form
    $('#checkoutButton').click(function() {
      $('#checkoutForm').submit();
    });
  </script>

</x-front-layout>
