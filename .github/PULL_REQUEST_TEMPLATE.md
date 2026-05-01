## Summary

What does this PR change and why?

## Type of Change

Add the label(s) on this PR that match the type of change(s) made. Available labels:

- `New Rule`: A new rule was added
- `New Config Option`: A new configuration option was added to an **existing** rule
- `Bug`: A bug fix
- `Documentation`: Documentation **only** changes
- `Refactor`: Refactor or internal cleanup with no behavior change
- `Dependencies`: Updates to dependacy file/s

## Checklist

Before requesting review, make sure you have done the following:

- Run `composer format` and confirmed it runs clean
- Run `composer analyze` and confirmed it passes
- Run `composer test` and confirmed it passes
- If a rule was added or changed, updated `docs/{RuleName}.md`
- If a rule was added, linked the new doc from `README.md`
- If configuration was added or changed, updated `config/extension.neon` (parameter schema, defaults, and service registration)

## Related Issues

Closes # (or N/A if not applicable)
