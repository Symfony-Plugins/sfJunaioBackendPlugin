// Handles Save/Edit/Delete Functions
(function($)
{
	$.forms = {
		updatedInputs: [],  // Stores all jquery input objs that have called the change event
		init: function()
		{
			this.attachTitleInside('.titleinside');

			// When a form is submitted we want to scrap the default text so it doesn't get saved in the DB
			$('form').submit(function()
			{
				$.forms.hideTitleInside('.titleinside');
			});
		},
		attachDeleteItem: function()
		{
			// This class should be applied to any button that is deleting something
			$('.deleteItem').unbind().click(function()
			{
				$deleteObj = $(this);

				$.confirm({title: "Are you sure you want to "+this.title+"?", callback: $.forms.deleteItem, callbackParams: $deleteObj});

				return false;
			}).mousedown(function(event){event.stopPropagation();});
		},
		attachInputChange: function(selector)
		{
			// Get all inputs and check to see if they get updated
			$(selector).change(function(event)
			{

			});
		},
		// Handles showing/hiding default text in input fields
		// Args: selector[string]
		attachTitleInside: function(selector)
		{
			if (!selector)
			{
				var selector = '.titleinside';
			}

			$(selector).each(function()
			{
				$this = $(this);

				$.data(this, 'title', $this.attr('title'));

				// If the value is empty insert default text
				if ($this.val() == '')
				{
					$this.val($.data(this, 'title'));
				}
				// If value does not equal default text add the focus class
				else if ($this.val() != $.data(this, 'title'))
				{
					if ($this.attr('type') != 'password')
					{
						$this.attr('title', $this.val());
					}

					$this.addClass('focus');
				}
			});

			$(selector).focus(function(event)
			{
				$this = $(this);

				// Add focus class
				if (!$this.hasClass('focus'))
				{
					$this.addClass('focus');
				}

			   	// If the value is the same as the default text we want to remove it
				if ($this.val() == $.data(this, 'title'))
				{
					$this.val('');
				}
			});

			$(selector).blur(function(event)
			{
				$this = $(this);

				// If the value is empty we want to add the default text
				if ($this.val() == '')
				{
					$this.removeClass('focus');
					$this.val($.data(this, 'title'));
				}

				if ($this.attr('type') != 'password')
				{
					$this.attr('title', $this.val());
				}
			});
		},
		hideTitleInside: function(selector)
		{
			$(selector).each(function()
			{
				if (this.value == $.data(this, 'title'))
				{
					this.value = '';
				}
			});
		},
		showTitleInside: function(selector)
		{
			$(selector).each(function()
			{
				if (this.value == '')
				{
					this.value = $.data(this, 'title');
				}
			});
		},
		// Adds default text back into input fields
		// Used in the case that a form submission fails
		// Args: result[boolean]
		submitResult: function(result)
		{
			if (result == false)
			{
				this.showTitleInside('.titleinside');
			}

			return result;
		}

	};

	$(document).ready(function()
	{
		// Initialize the forms methods
		$.forms.init();
	});
})(jQuery);
