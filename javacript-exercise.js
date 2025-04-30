// Get the current date and time
var today = new Date();

// Get the day of the week (0-6, where 0 is Sunday and 6 is Saturday)
var day = today.getDay();

// Convert to ordinal format (1st, 2nd, 3rd, etc.)
var ordinalDay = day + 1;
var suffix = "th";
if (ordinalDay === 1 || ordinalDay === 21 || ordinalDay === 31) {
    suffix = "st";
} else if (ordinalDay === 2 || ordinalDay === 22) {
    suffix = "nd";
} else if (ordinalDay === 3 || ordinalDay === 23) {
    suffix = "rd";
}
console.log("Today is : " + ordinalDay + suffix + " Day of the Week");

// Get the current hour, minute, and second
var hour = today.getHours();
var minute = today.getMinutes();
var second = today.getSeconds();

// Determine if it's AM or PM
var period = (hour >= 12) ? "PM" : "AM";

// Convert 24-hour format to 12-hour format
hour = hour % 12;
hour = (hour === 0) ? 12 : hour;

// Pad minute and second with leading zeros if needed
minute = (minute < 10) ? "0" + minute : minute;
second = (second < 10) ? "0" + second : second;

console.log("Current Time : " + hour + " : " + minute + " : " + second + " " + period);
