# Exercise 02: Enhancing Validation

## 🎯 Objective
Learn how to implement custom validation rules and improve the feedback loop.

## 📝 Task
1.  **Name Length Constraint**: Add a validation rule that requires the `name` to be at least 2 characters long. If it's shorter, show the error: "Name is too short."
2.  **Custom Email Regex**: Instead of (or in addition to) `filter_var`, try to implement a simple check to ensure the email ends with `.com` or `.org`.
3.  **Success Styling**: Currently, the success alert is just a green box. Change the code so that when an entry is successfully posted, the "Your Name" input field is automatically focused using the HTML `autofocus` attribute (hint: use a GET parameter or a PHP flag).

## 💡 Hints
- Use `strlen($name)` for the length check.
- Use `str_ends_with($email, '.com')` (PHP 8+) for the email check.

## 🧪 Verification
- Try to submit the name "A". You should see an error.
- Submit a valid entry and check if the success message appears.
- Try to "hack" the app by submitting `<marquee>Hello</marquee>`. It should be displayed safely as text.
