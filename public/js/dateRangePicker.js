const MONTH_NAMES = [
	"January",
	"February",
	"March",
	"April",
	"May",
	"June",
	"July",
	"August",
	"September",
	"October",
	"November",
	"December",
];
const DAYS = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

document.addEventListener("alpine:init", () => {
	Alpine.data("app", () => ({
		showDatepicker: false,
		dateFromYmd: "",
		dateToYmd: "",
		outputDateFromValue: "",
		outputDateToValue: "",
		dateFromValue: "",
		dateToValue: "",
		currentDate: null,
		dateFrom: null,
		dateTo: null,
		endToShow: "",
		selecting: false,
		month: "",
		year: "",
		no_of_days: [],
		blankdays: [],

		convertFromYmd(dateYmd) {
			const year = Number(dateYmd.substr(0, 4));
			const month = Number(dateYmd.substr(5, 2)) - 1;
			const date = Number(dateYmd.substr(8, 2));

			return new Date(year, month, date);
		},

		convertToYmd(dateObject) {
			const year = dateObject.getFullYear();
			const month = dateObject.getMonth() + 1;
			const date = dateObject.getDate();

			return ("0" + date).slice(-2) + " " + ("0" + month).slice(-2) + " " + year;
			// return year + "-" + ("0" + month).slice(-2) + "-" + ("0" + date).slice(-2);
		},

		init() {
			this.selecting = (this.endToShow === "to" && this.dateTo) || (this.endToShow === "from" && this.dateFrom);
			if (!this.dateFrom) {
				if (this.dateFromYmd) {
					this.dateFrom = this.convertFromYmd(this.dateFromYmd);
				}
			}
			if (!this.dateTo) {
				if (this.dateToYmd) {
					this.dateTo = this.convertFromYmd(this.dateToYmd);
				}
			}
			if (!this.dateFrom) {
				this.dateFrom = this.dateTo;
			}
			if (!this.dateTo) {
				this.dateTo = this.dateFrom;
			}
			if (this.endToShow === "from" && this.dateFrom) {
				this.currentDate = this.dateFrom;
			} else if (this.endToShow === "to" && this.dateTo) {
				this.currentDate = this.dateTo;
			} else {
				this.currentDate = new Date();
			}
			currentMonth = this.currentDate.getMonth();
			currentYear = this.currentDate.getFullYear();
			if (this.month !== currentMonth || this.year !== currentYear) {
				this.month = currentMonth;
				this.year = currentYear;
				this.getNoOfDays();
			}
			this.setDateValues();
		},

		isToday(date) {
			const today = new Date();
			const d = new Date(this.year, this.month, date);

			return today.toDateString() === d.toDateString();
		},

		isDateFrom(date) {
			const d = new Date(this.year, this.month, date);

			if (!this.dateFrom) {
				return false;
			}

			return d.getTime() === this.dateFrom.getTime();
		},

		isDateTo(date) {
			const d = new Date(this.year, this.month, date);

			if (!this.dateTo) {
				return false;
			}

			return d.getTime() === this.dateTo.getTime();
		},

		isInRange(date) {
			const d = new Date(this.year, this.month, date);

			return d > this.dateFrom && d < this.dateTo;
		},

		outputDateValues() {
			if (this.dateFrom) {
				// this.outputDateFromValue = this.dateFrom.toDateString();
				this.outputDateFromValue = this.convertToYmd(this.dateFrom); //for showing only
				this.dateFromYmd = this.convertToYmd(this.dateFrom); //for RESULT input field
			}
			if (this.dateTo) {
				// this.outputDateToValue = this.dateTo.toDateString();
				this.outputDateToValue = this.convertToYmd(this.dateTo); //for showing only
				this.dateToYmd = this.convertToYmd(this.dateTo); //for RESULT input field
			}
		},

		setDateValues() {
			if (this.dateFrom) {
				this.dateFromValue = this.dateFrom.toDateString();
			}
			if (this.dateTo) {
				this.dateToValue = this.dateTo.toDateString();
			}
		},

		getDateValue(date, temp) {
			// if we are in mouse over mode but have not started selecting a range, there is nothing more to do.
			if (temp && !this.selecting) {
				return;
			}
			let selectedDate = new Date(this.year, this.month, date);
			if (this.endToShow === "from") {
				this.dateFrom = selectedDate;
				if (!this.dateTo) {
					this.dateTo = selectedDate;
				} else if (selectedDate > this.dateTo) {
					this.endToShow = "to";
					this.dateFrom = this.dateTo;
					this.dateTo = selectedDate;
				}
			} else if (this.endToShow === "to") {
				this.dateTo = selectedDate;
				if (!this.dateFrom) {
					this.dateFrom = selectedDate;
				} else if (selectedDate < this.dateFrom) {
					this.endToShow = "from";
					this.dateTo = this.dateFrom;
					this.dateFrom = selectedDate;
				}
			}
			this.setDateValues();

			if (!temp) {
				if (this.selecting) {
					this.outputDateValues();
					this.closeDatepicker();
				}
				this.selecting = !this.selecting;
			}
		},

		getNoOfDays() {
			let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();

			// find where to start calendar day of week
			let dayOfWeek = new Date(this.year, this.month).getDay();
			let blankdaysArray = [];
			for (var i = 1; i <= dayOfWeek; i++) {
				blankdaysArray.push(i);
			}

			let daysArray = [];
			for (var i = 1; i <= daysInMonth; i++) {
				daysArray.push(i);
			}

			this.blankdays = blankdaysArray;
			this.no_of_days = daysArray;
		},

		closeDatepicker() {
			this.endToShow = "";
			this.showDatepicker = false;
		},
	}));
});
