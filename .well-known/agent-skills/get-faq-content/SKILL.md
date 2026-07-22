# GetFAQContent

## Description
Access the Consultoria Exato FAQ with 103 expert questions and answers covering occupational safety, environmental management, and industrial radiation protection in Brazil.

## Parameters
- `topic` (string, optional): Topic filter. Accepted values: `"occupational_safety"`, `"environment"`, `"radiation_protection"`, `"about_exato"`, `"all"`. Default: `"all"`.
- `language` (string, optional): Response language. Accepted values: `"pt-BR"`, `"en-US"`. Default: `"pt-BR"`.

## Behavior
Directs to the appropriate FAQ resource based on language and topic. No authentication required.

## Resources

| Language | Format | URL |
|---|---|---|
| Portuguese | HTML | https://consultoriaexato.com.br/faq/ |
| English | HTML | https://consultoriaexato.com.br/en/faq/ |
| Portuguese | Markdown | https://consultoriaexato.com.br/faq/ (request with `Accept: text/markdown`) |
| English | Markdown | https://consultoriaexato.com.br/en/faq/ (request with `Accept: text/markdown`) |

## Topic Coverage

### About Exato (Questions 1–6)
Services offered, how to hire, ongoing vs. one-off engagements, investment prioritization, defense against fines.

### Occupational Safety (Questions 7–32)
NRs, safety engineering, risk management (GRO/NR-1), audits, accident investigation, safety culture, PPE, mandatory training, EHS documentation, ISO 14001 / ISO 45001.

### Environment (Questions 33–60+)
CETESB, IBAMA, CONAMA, environmental licensing (LP/LI/LO), EIA/RIMA, solid waste (PGRS, CADRI, MTR, PNRS), reverse logistics, water monitoring, effluent management, environmental fines defense.

### Radiation Protection (Questions 61–103)
ANSN/CNEN regulations, nuclear gauges, radiation protection supervisors, OEI training, ionizing radiation sources, physical protection plans, RFAS.

## Example Request
```json
{
  "topic": "radiation_protection",
  "language": "en-US"
}
```

## Example Response
```json
{
  "topic": "radiation_protection",
  "language": "en-US",
  "question_range": "61–103",
  "resource_url": "https://consultoriaexato.com.br/en/faq/",
  "markdown_url": "https://consultoriaexato.com.br/en/faq/",
  "markdown_accept_header": "text/markdown"
}
```

## Notes
- All 103 questions authored by Paulo Cassim, licensed ANSN Radiation Protection Supervisor with 28+ years of EHS experience.
- Content available in Brazilian Portuguese and American English.
