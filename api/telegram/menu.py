import logging
from telegram import Update, InlineKeyboardMarkup, InlineKeyboardButton
from telegram.ext import Updater, CommandHandler, CallbackQueryHandler, CallbackContext

# Set up logging
logging.basicConfig(format='%(asctime)s - %(name)s - %(levelname)s - %(message)s', level=logging.INFO)

# Initialize the bot
updater = Updater(token='6533824375:AAFICZ_03tGu1QD4gG0CHHwLlJha1fnBCQ8', use_context=True)
dispatcher = updater.dispatcher

# Define a command to start the bot and show the menu
def start(update: Update, context: CallbackContext):
    keyboard = [[InlineKeyboardButton("Menu", callback_data='menu')]]
    reply_markup = InlineKeyboardMarkup(keyboard)
    update.message.reply_text('Welcome to your chatbot! Please choose an option:', reply_markup=reply_markup)

# Define a function to handle button clicks
def button(update: Update, context: CallbackContext):
    query = update.callback_query
    query.answer()

    if query.data == 'menu':
        keyboard = [[InlineKeyboardButton("Option 1", callback_data='option1'),
                     InlineKeyboardButton("Option 2", callback_data='option2')]]
        reply_markup = InlineKeyboardMarkup(keyboard)
        query.edit_message_text('Choose an option:', reply_markup=reply_markup)

# Register command and button click handlers
dispatcher.add_handler(CommandHandler('start', start))
dispatcher.add_handler(CallbackQueryHandler(button))

# Start the bot
updater.start_polling()
updater.idle()
