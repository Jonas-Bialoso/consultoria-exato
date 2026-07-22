# GetServiceInfo

## Description
Retrieve detailed information about EHS consulting services offered by Consultoria Exato, including occupational safety, environmental management, and industrial radiation protection.

## Parameters
- `service_area` (string, optional): Area of interest. Accepted values: `"occupational_safety"`, `"environment"`, `"radiation_protection"`, `"all"`. Default: `"all"`.
- `language` (string, optional): Response language. Accepted values: `"pt-BR"`, `"en-US"`. Default: `"pt-BR"`.

## Behavior
Returns a structured description of services available in the requested area. This is an informational resource — no authentication required.

## Resources
- Portuguese: https://consultoriaexato.com.br/
- English: https://consultoriaexato.com.br/en/
- Markdown (machine-readable): https://consultoriaexato.com.br/index.md (request with `Accept: text/markdown`)

## Service Areas

### Occupational Safety (Segurança do Trabalho)
Consulting focused on compliance with Brazilian Regulatory Standards (NRs). Includes audits, accident investigation, risk management (GRO/NR-1), confined spaces (NR-33), work at height (NR-35), lockout/tagout, contractor safety management, and safety training.

### Environment (Meio Ambiente)
Environmental assessments, CETESB licensing, solid waste management (PGRS, CADRI), liquid effluent management, atmospheric emissions, water monitoring, environmental due diligence, and defense against environmental fines (CETESB, IBAMA).

### Industrial Radiation Protection (Radioproteção Industrial)
ANSN/CNEN supervision for nuclear measurement gauges, radiation protection plans, OEI (Occupationally Exposed Individuals) training, ANSN licensing support, and physical protection plans.

## Example Request
```json
{
  "service_area": "radiation_protection",
  "language": "en-US"
}
```

## Example Response
```json
{
  "service_area": "radiation_protection",
  "language": "en-US",
  "description": "Industrial Radiation Protection supervision and licensing for companies using nuclear measurement gauges, as required by ANSN/CNEN Brazilian regulations.",
  "source": "https://consultoriaexato.com.br/en/"
}
```

## Notes
- Consultoria Exato operates primarily in the state of São Paulo, Brazil.
- Principal consultant: Paulo Cassim, licensed ANSN Radiation Protection Supervisor.
- Contact: contato@consultoriaexato.com.br | WhatsApp: +5516997888750
