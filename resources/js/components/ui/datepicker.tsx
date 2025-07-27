"use client"

import * as React from "react"
import { format } from "date-fns"
import { Calendar as CalendarIcon } from "lucide-react"

import { cn } from "@/lib/utils"
import { Button } from "@/components/ui/button"
import { Calendar } from "@/components/ui/calendar"
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from "@/components/ui/popover"

type DatePickerProps = {
    value?: Date
    onChange?: (date: Date | undefined) => void
    placeholder?: string
    className?: string
}

export function DatePicker({
                               value,
                               onChange,
                               placeholder = "Pick a date",
                               className,
                           }: DatePickerProps) {
    const [internalDate, setInternalDate] = React.useState<Date | undefined>(value)

    const selectedDate = value !== undefined ? value : internalDate

    const handleSelect = (date: Date | undefined) => {
        if (!value) {
            setInternalDate(date)
        }
        onChange?.(date)
    }

    return (
        <Popover>
            <PopoverTrigger asChild>
                <Button
                    variant="outline"
                    data-empty={!selectedDate}
                    className={cn(
                        "w-full min-w-[200px] justify-start text-left font-normal data-[empty=true]:text-muted-foreground",
                        className
                    )}
                >
                    <CalendarIcon className="mr-2 h-4 w-4" />
                    {selectedDate ? format(selectedDate, "PPP") : <span>{placeholder}</span>}
                </Button>
            </PopoverTrigger>
            <PopoverContent className="w-auto p-0">
                <Calendar
                    mode="single"
                    selected={selectedDate}
                    onSelect={handleSelect}
                />
            </PopoverContent>
        </Popover>
    )
}
